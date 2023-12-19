<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\GraveRepository;
use App\Entity\Grave;
use App\Form\GraveFormType;
use App\Form\GraveSearchFormType;
use Countable;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('ROLE_TECHNICAL_OFFICE')]
class GraveController extends BaseController
{
    public function __construct(
        private readonly GraveRepository $repo, 
        private readonly EntityManagerInterface $em, 
        private readonly TranslatorInterface $translator)
    {
    }

    #[Route(path: '/{_locale}/grave/new', name: 'grave_new')]
    public function new(Request $request): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(GraveFormType::class, new Grave(),[
            'new' => true,
            'readonly' => false,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            /** @var Grave $data */ 
            $data = $form->getData();
            $this->addFlash('success', 'messages.graveSaved');
            $this->em->persist($data);
            $this->em->flush();
            return $this->redirectToRoute('grave_index');
        }
        return $this->renderForm('grave/edit.html.twig',[
            'form' => $form,
            'new' => true,
            'readonly' => false,
        ]);
    }

    #[Route(path: '/{_locale}/grave/{grave}/edit', name: 'grave_edit')]
    public function edit(Grave $grave, Request $request): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(GraveFormType::class, $grave,[
            'new' => false,
            'readonly' => false,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            /** @var Grave $data */ 
            $data = $form->getData();
            $this->addFlash('success', 'messages.graveSaved');
            $this->em->persist($data);
            $this->em->flush();
            return $this->redirectToRoute('grave_index');
        }
        return $this->renderForm('grave/edit.html.twig',[
            'form' => $form,
            'new' => false,
            'readonly' => false,
        ]);
    }

    #[Route(path: '/{_locale}/grave/{grave}/delete', name: 'grave_delete', methods: ['DELETE'])]
    public function delete(Grave $grave, Request $request): Response
    {
        if ($this->checkIfHasAdjudications($grave->getAdjudications())) {
            return new Response($this->translator->trans('messages.graveHasAdjudications'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($this->checkIfHasSourceMovements($grave->getSourceMovements())) {
            return new Response($this->translator->trans('messages.graveHasSourceMovements'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($this->checkIfHasDestinationMovements($grave->getDestinationMovements())) {
            return new Response($this->translator->trans('messages.graveHasDestinationMovements'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($this->isCsrfTokenValid('delete'.$grave->getId(), $request->get('_token'))) {
            $this->em->remove($grave);
            $this->em->flush();
            if (!$request->isXmlHttpRequest()) {
                return $this->redirectToRoute('grave_index');
            } else {
                return new Response(null, Response::HTTP_NO_CONTENT);
            }
        } else {
            return new Response('messages.invalidCsrfToken', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

    }

    #[Route(path: '/{_locale}/grave/{grave}', name: 'grave_show')]
    public function show(Grave $grave, Request $request): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(GraveFormType::class, $grave,[
            'new' => false,
            'readonly' => true,
        ]);
        return $this->renderForm('grave/edit.html.twig',[
            'form' => $form,
            'new' => false,
            'readonly' => true,
        ]);
    }

    #[Route(path: '/{_locale}/grave', name: 'grave_index')]
    public function index(Request $request): Response
    {
        $graves = [];
        $this->loadQueryParameters($request);
        $form = $this->createForm(GraveSearchFormType::class, null,[
            'readonly' => false,
            'locale' => $request->getLocale(),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $data = $form->getData();
            $criteria = $this->removeBlankFilters($data);
            if (count($criteria) === 0 ) {
                $this->addFlash('error', 'messages.selectOneFilterAlLeast');
                $template = !$this->getAjax() ? 'grave/index.html.twig' : 'grave/_list.html.twig';
                return $this->renderForm($template, [
                    'graves' => $graves,
                    'form' => $form,
                    'readonly' => false,
                ]);        
            }
            $graves = $this->repo->findBy($criteria);
        }
        $template = !$this->getAjax() ? 'grave/index.html.twig' : 'grave/_list.html.twig';
        return $this->renderForm($template, [
            'graves' => $graves,
            'form' => $form,
            'readonly' => false,
        ]);        
    }

    private function checkIfHasAdjudications($adjudications): bool {
        return !$this->hasElements($adjudications);
    }

    private function checkIfHasSourceMovements($sources): bool {
        return !$this->hasElements($sources);
    }

    private function checkIfHasDestinationMovements($destinations): bool {
        return !$this->hasElements($destinations);
    }
}
