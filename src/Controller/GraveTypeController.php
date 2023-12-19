<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\GraveType;
use App\Form\GraveTypeFormType;
use App\Repository\GraveTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(path: '/{_locale}/admin')]
class GraveTypeController extends BaseController
{

    public function __construct(
        private readonly GraveTypeRepository $repo, 
        private readonly EntityManagerInterface $em, 
        private readonly TranslatorInterface $translator)
    {
    }

    #[Route(path: '/grave-type/new', name: 'graveType_new')]
    public function new(Request $request): Response 
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(GraveTypeFormType::class, new GraveType(),[

        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var GraveType $data */
            $data = $form->getData();
            if (null !== $data->getId()) {
                $graveType = $this->repo->find($data->getId());
                $graveType->fill($data);
            } elseif ($this->checkAlreadyExists($data)) {
                $this->addFlash('error', 'messages.graveTypeAlreadyExist');
                $template = $this->getAjax() || $request->isXmlHttpRequest() ? '_form.html.twig' : 'edit.html.twig';
                return $this->renderForm('grave-type/' . $template, [
                    'form' => $form,
                    'new' => true,
                    'readonly' => false,
                ], new Response(null, Response::HTTP_UNPROCESSABLE_ENTITY));        
            } else {
                $graveType = $data;
            }
            $this->em->persist($graveType);
            $this->em->flush();
        }

        $template = $this->getAjax() || $request->isXmlHttpRequest() ? '_form.html.twig' : 'edit.html.twig';
        return $this->renderForm('grave-type/' . $template, [
            'form' => $form,
            'new' => true,
            'readonly' => false,
        ],  new Response(null, $form->isSubmitted() && ( !$form->isValid() )? 422 : 200));        
    }

    #[Route(path: '/grave-type/{graveType}', name: 'graveType_show')]
    public function show(GraveType $graveType, Request $request): Response 
    {
        $form = $this->createForm(GraveTypeFormType::class, $graveType, [
            'readonly' => true,
      ]);
      $template = $this->getAjax() || $request->isXmlHttpRequest() ? '_form.html.twig' : 'edit.html.twig';
      return $this->renderForm('grave-type/' . $template, [
            'graveType' => $graveType,
            'form' => $form,
            'readonly' => true,
            'new' => false,
      ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200,));
    }

    #[Route(path: '/grave-type/{graveType}/edit', name: 'graveType_edit')]
    public function edit(GraveType $graveType, Request $request): Response 
    {
        $form = $this->createForm(GraveTypeFormType::class, $graveType, [
            'readonly' => false,
      ]);
      $template = $this->getAjax() || $request->isXmlHttpRequest() ? '_form.html.twig' : 'edit.html.twig';
      return $this->renderForm('grave-type/' . $template, [
            'GraveType' => $graveType,
            'form' => $form,
            'readonly' => false,
            'new' => false,
      ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200,));
    }

    #[Route(path: '/grave-type/{graveType}/delete', name: 'graveType_delete', methods: ['DELETE'])]
    public function delete(GraveType $graveType, Request $request): Response 
    {
        if ( !$this->checkRemovable($graveType->getGraves())) {
            return new Response($this->translator->trans('messages.graveTypeHasGraves'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($this->isCsrfTokenValid('delete'.$graveType->getId(), $request->get('_token'))) {
            $this->em->remove($graveType);
            $this->em->flush();
            if (!$request->isXmlHttpRequest() && !$this->getAjax()) {
                return $this->redirectToRoute('graveType_index');
            } else {
                return new Response(null, Response::HTTP_NO_CONTENT);
            }
        } else {
            return new Response('messages.invalidCsrfToken', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    #[Route(path: '/grave-type', name: 'graveType_index')]
    public function index(Request $request): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(GraveTypeFormType::class, new GraveType());
        $graveTypes = $this->repo->findAll();
        
        $template = !$this->getAjax() ? 'grave-type/index.html.twig' : 'grave-type/_list.html.twig';
        return $this->render($template, [
            'graveTypes' => $graveTypes,
            'form' => $form,
        ]);        
    }

    /**
     * Checks if it's already a grave type with that description
     */
    public function checkAlreadyExists(GraveType $graveType) {
        $result = $this->repo->findOneBy([
            'descriptionEs' => $graveType->getDescriptionEs(),
        ]);
        $result2 = $this->repo->findOneBy([
            'descriptionEu' => $graveType->getDescriptionEu(),
        ]);

        if ($result !== null || $result2 !== null) {
            return true;
        }
        return false;
    }

    /**
     * If there is at least one grave of that type if can't be removed.
     * 
     * So this checks if it has elements
     */
    private function checkRemovable($graves): bool {
        return !$this->hasElements($graves);
    }
}
