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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

/** 
* @IsGranted("ROLE_UNDERTAKER")
*/
class GraveController extends BaseController
{
    private GraveRepository $repo;
    private EntityManagerInterface $em;
    private TranslatorInterface $translator;

    public function __construct(GraveRepository $repo, EntityManagerInterface $em, TranslatorInterface $translator)
    {
        $this->repo = $repo;
        $this->em = $em;
        $this->translator = $translator;
    }

    /**
     * @Route("/{_locale}/grave/new", name="grave_new")
     */
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

    /**
     * @Route("/{_locale}/grave/{grave}/edit", name="grave_edit")
     */
    public function edit(Grave $grave, Request $request): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(GraveFormType::class, $grave,[
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
            'new' => false,
            'readonly' => false,
        ]);
    }

    /**
     * @Route("/{_locale}/grave/{grave}/delete", name="grave_delete", methods={"DELETE"})
     */
    public function delete(Grave $grave, Request $request): Response
    {
        if ($this->checkIfHasAdjudications($grave->getAdjudications())) {
            return new Response($this->translator->trans('messages.graveHasAdjudications'), 422);
        }
        if ($this->checkIfHasSourceMovements($grave->getSourceMovements())) {
            return new Response($this->translator->trans('messages.graveHasSourceMovements'), 422);
        }
        if ($this->checkIfHasDestinationMovements($grave->getDestinationMovements())) {
            return new Response($this->translator->trans('messages.graveHasDestinationMovements'), 422);
        }
        if ($this->isCsrfTokenValid('delete'.$grave->getId(), $request->get('_token'))) {
            $this->em->remove($grave);
            $this->em->flush();
            if (!$request->isXmlHttpRequest()) {
                return $this->redirectToRoute('grave_index');
            } else {
                return new Response(null, 204);
            }
        } else {
            return new Response('messages.invalidCsrfToken', 422);
        }

    }

    /**
     * @Route("/{_locale}/grave/{grave}", name="grave_show")
     */
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

    /**
     * @Route("/{_locale}/grave", name="grave_index")
     */
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
