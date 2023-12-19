<?php

namespace App\Controller;

use App\Entity\Owner;
use App\Form\OwnerFormType;
use App\Form\OwnerSearchFormType;
use App\Repository\OwnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(path: '/{_locale}')]
class OwnerController extends BaseController
{

    public function __construct(
        private readonly OwnerRepository $repo, 
        private readonly EntityManagerInterface $em, 
        private readonly TranslatorInterface $translator)
    {
    }

    #[Route(path: '/owner/new', name: 'owner_new')]
    public function new(Request $request): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(OwnerFormType::class, new Owner(),[
            'new' => true,
            'readonly' => false,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            /** @var Owner $data */ 
            $data = $form->getData();
            $exists = $this->checkIfExists($data);
            if ($exists) {
                $this->addFlash('error',new TranslatableMessage('messages.ownerAlreadyExists',[
                    '{dni}' => $data->getDni(),
                    '{fullname}' => $data->getFullname(),
                ]));
                return $this->renderForm('owner/edit.html.twig',[
                    'form' => $form,
                    'new' => true,
                    'readonly' => false,
                ]);
            }
            $this->addFlash('success', 'messages.ownerSaved');
            $this->em->persist($data);
            $this->em->flush();
            return $this->redirectToRoute('owner_index',[
                'id' => $data->getId(),
            ]);
        }
        return $this->renderForm('owner/edit.html.twig',[
            'form' => $form,
            'new' => true,
            'readonly' => false,
        ]);
    }

    #[Route(path: '/owner/{owner}/edit', name: 'owner_edit')]
    public function edit(Owner $owner, Request $request): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(OwnerFormType::class, $owner,[
            'new' => false,
            'readonly' => false,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            /** @var Owner $data */ 
            $data = $form->getData();
            $this->addFlash('success', 'messages.ownerSaved');
            $this->em->persist($data);
            $this->em->flush();
            return $this->redirectToRoute('owner_index');
        }
        return $this->renderForm('owner/edit.html.twig',[
            'form' => $form,
            'new' => false,
            'readonly' => false,
        ]);
    }

    #[Route(path: '/owner/{owner}/delete', name: 'owner_delete', methods: ['DELETE'])]
    public function delete(Owner $owner, Request $request): Response
    {
        if ( !$this->checkRemovable($owner->getAdjudications()) ) {
            return new Response($this->translator->trans('messages.ownerHasAdjudications'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($this->isCsrfTokenValid('delete'.$owner->getId(), $request->get('_token'))) {
            $this->em->remove($owner);
            $this->em->flush();
            if (!$request->isXmlHttpRequest()) {
                return $this->redirectToRoute('owner_index');
            } else {
                return new Response(null, Response::HTTP_NO_CONTENT);
            }
        } else {
            return new Response('messages.invalidCsrfToken', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

    }

    #[Route(path: '/owner/{owner}', name: 'owner_show')]
    public function show(Owner $owner, Request $request): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(OwnerFormType::class, $owner,[
            'new' => false,
            'readonly' => true,
        ]);
        return $this->renderForm('owner/edit.html.twig',[
            'form' => $form,
            'new' => false,
            'readonly' => true,
        ]);
    }


    #[Route(path: '/owner', name: 'owner_index')]
    public function index(Request $request): Response
    {
        $this->loadQueryParameters($request);
        $criteria = $request->query->all();
        $criteria = $this->removePaginationParameters($criteria);
        $form = $this->createForm(OwnerSearchFormType::class, null,[]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $criteria = $form->getData();
            if ( count($this->removeBlankFilters($criteria)) === 0 ) {
                $this->addFlash('error','messages.selectAtLeastOneFilter');
            }
        }
        $criteria = $this->removeBlankFilters($criteria);
        $owners = (count($criteria) === 0) ? [] : $this->repo->findByCriteria($criteria);
        $template = !$this->getAjax() ? 'owner/index.html.twig' : 'owner/_list.html.twig';
        return $this->renderForm($template, [
            'owners' => $owners,
            'form' => $form,
            'filters' => $criteria,
        ]);        
    }

    private function checkIfExists(Owner $data) {
        $owner = $this->repo->findOneBy([
            'fullname' => $data->getFullname(), 
        ]);
        if ($owner === null) {
            $owner = $this->repo->findOneBy([
                'dni' => $data->getDni(), 
            ]);
        }
        if ($owner !== null) {
            return true;
        }

        return false;
    }

    /**
     * @param Adjudication[] $adjudications La matriz de objetos Adjudication.
     *
     * @return bool Devuelve false si no se puede borrar porque tiene alguna adjudicación vigente o en estado desconocido.
     */
    private function checkRemovable($adjudications): bool {
        return !$this->hasElements($adjudications);
    }
}
