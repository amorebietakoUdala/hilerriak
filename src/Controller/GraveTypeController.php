<?php

namespace App\Controller;

use App\Entity\Cemetery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\GraveType;
use App\Form\GraveTypeFormType;
use App\Repository\GraveTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/{_locale}/admin")
 */
class GraveTypeController extends BaseController
{

    private GraveTypeRepository $repo;
    private EntityManagerInterface $em;
    private TranslatorInterface $translator;

    public function __construct(GraveTypeRepository $repo, EntityManagerInterface $em, TranslatorInterface $translator)
    {
        $this->repo = $repo;
        $this->em = $em;
        $this->translator = $translator;
    }

    /**
     * @Route("/grave-type/new", name="graveType_new")
     */
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
                ], new Response(null, 422));        
            } else {
                $$graveType = $data;
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

    /**
     * @Route("/grave-type/{graveType}", name="graveType_show")
     */
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

    /**
     * @Route("/grave-type/{graveType}/edit", name="graveType_edit")
     */
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

    /**
     * @Route("/grave-type/{graveType}/delete", name="graveType_delete", methods={"DELETE"})
     */
    public function delete(GraveType $graveType, Request $request): Response 
    {
        if ( $this->checkRemovable($graveType->getGraves())) {
            return new Response($this->translator->trans('messages.graveTypeHasGraves'), 422);
        }
        if ($this->isCsrfTokenValid('delete'.$graveType->getId(), $request->get('_token'))) {
            $this->em->remove($graveType);
            $this->em->flush();
            if (!$request->isXmlHttpRequest() && !$this->getAjax()) {
                return $this->redirectToRoute('graveType_index');
            } else {
                return new Response(null, 204);
            }
        } else {
            return new Response('messages.invalidCsrfToken', 422);
        }
    }

    /**
     * @Route("/grave-type", name="graveType_index")
     */
    public function index(Request $request): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(GraveTypeFormType::class, new GraveType());
        $graveTypes = $this->repo->findAll();
        
        $template = !$this->getAjax() ? 'grave-type/index.html.twig' : 'grave-type/_list.html.twig';
        return $this->render($template, [
            'graveTypes' => $graveTypes,
            'form' => $form->createView(),
        ]);        
    }

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

    private function checkRemovable($graves): bool {
        return !$this->hasElements($graves);
    }
}
