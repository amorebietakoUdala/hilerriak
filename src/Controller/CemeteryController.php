<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cemetery;
use App\Entity\Grave;
use App\Entity\GraveType;
use App\Form\CemeteryFormType;
use App\Form\ZoneCreationFormType;
use App\Repository\CemeteryRepository;
use App\Repository\GraveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class CemeteryController extends BaseController
{

    private CemeteryRepository $repo;
    private EntityManagerInterface $em;
    private GraveRepository $graveRepo;
    private TranslatorInterface $translator;

    public function __construct(CemeteryRepository $repo, GraveRepository $graveRepo, EntityManagerInterface $em, TranslatorInterface $translator)
    {
        $this->repo = $repo;
        $this->graveRepo = $graveRepo;
        $this->em = $em;
        $this->translator = $translator;
    }

    /**
     * @Route("/{_locale}/admin/cemetery/new", name="cemetery_new")
     */
    public function new(Request $request): Response 
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(CemeteryFormType::class, new Cemetery(),[

        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Cemetery $data */
            $data = $form->getData();
            if (null !== $data->getId()) {
                $cemetery = $this->repo->find($data->getId());
                $cemetery->fill($data);
            } elseif ($this->checkAlreadyExists($data)) {
                $this->addFlash('error', 'messages.cemeteryAlreadyExist');
                $template = $this->getAjax() || $request->isXmlHttpRequest() ? '_form.html.twig' : 'edit.html.twig';
                return $this->renderForm('cemetery/' . $template, [
                    'form' => $form,
                    'new' => true,
                    'readonly' => false,
                ], new Response(null, 422));        
            } else {
                $cemetery = $data;
            }
            $this->em->persist($cemetery);
            $this->em->flush();
        }

        $template = $this->getAjax() || $request->isXmlHttpRequest() ? '_form.html.twig' : 'edit.html.twig';
        return $this->renderForm('cemetery/' . $template, [
            'form' => $form,
            'new' => true,
            'readonly' => false,
        ],  new Response(null, $form->isSubmitted() && ( !$form->isValid() )? 422 : 200));        
    }

    /**
     * @Route("/{_locale}/admin/cemetery/{cemetery}", name="cemetery_show")
     */
    public function show(Cemetery $cemetery, Request $request): Response 
    {
        $form = $this->createForm(CemeteryFormType::class, $cemetery, [
            'readonly' => true,
      ]);
      $template = $this->getAjax() || $request->isXmlHttpRequest() ? '_form.html.twig' : 'edit.html.twig';
      return $this->renderForm('cemetery/' . $template, [
            'cemetery' => $cemetery,
            'form' => $form,
            'readonly' => true,
            'new' => false,
      ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200,));
    }

    /**
     * @Route("/{_locale}/admin/cemetery/{cemetery}/edit", name="cemetery_edit")
     */
    public function edit(Cemetery $cemetery, Request $request): Response 
    {
        $form = $this->createForm(CemeteryFormType::class, $cemetery, [
            'readonly' => false,
      ]);
      $template = $this->getAjax() || $request->isXmlHttpRequest() ? '_form.html.twig' : 'edit.html.twig';
      return $this->renderForm('cemetery/' . $template, [
            'cemetery' => $cemetery,
            'form' => $form,
            'readonly' => false,
            'new' => false,
      ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200,));
    }

    /**
     * @Route("/{_locale}/admin/cemetery/{cemetery}/delete", name="cemetery_delete", methods={"DELETE"})
     */
    public function delete(Cemetery $cemetery, Request $request): Response 
    {
        if ($this->checkRemovable($cemetery->getGraves())) {
            return new Response($this->translator->trans('messages.cemeteryHasGraves'), 422);
        }

        if ($this->isCsrfTokenValid('delete'.$cemetery->getId(), $request->get('_token'))) {
            $this->em->remove($cemetery);
            $this->em->flush();
            if (!$request->isXmlHttpRequest() && !$this->getAjax()) {
                return $this->redirectToRoute('cemetery_index');
            } else {
                return new Response(null, 204);
            }
        } else {
            return new Response('messages.invalidCsrfToken', 422);
        }
    }

    /**
     * @Route("/{_locale}/cemetery/{cemetery}/new/zone", name="cemetery_new_zone")
     * @IsGranted("ROLE_UNDERTAKER")
     */
    public function newZone(Cemetery $cemetery, Request $request): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(ZoneCreationFormType::class,null,[
            'locale' => $request->getLocale(),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // TODO comprobar que la letra no exista previamente.
            $exists = $this->checkLetterAlreadyExists($cemetery, $data['letter']);
            if ($exists) {
                $this->addFlash('error', 'messages.letterAlreadyExists');
                return $this->renderForm('cemetery/zoneCreation.html.twig',[
                    'form' => $form,
                    'cemetery' => $cemetery,
                ]);
            }
            $graves = $this->createGraves($cemetery, $data);
            $this->em->flush();
            $this->addFlash('success','messages.newZoneCreated');
            return $this->redirectToRoute('cemetery_index');
        }

        return $this->renderForm('cemetery/zoneCreation.html.twig',[
            'form' => $form,
            'cemetery' => $cemetery,
        ]);
    }

    /**
     * @Route("/{_locale}/admin/cemetery", name="cemetery_index")
     */
    public function index(Request $request): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(CemeteryFormType::class, new Cemetery());
        $cemeterys = $this->repo->findAll();
        
        $template = !$this->getAjax() ? 'cemetery/index.html.twig' : 'cemetery/_list.html.twig';
        return $this->render($template, [
            'cemeterys' => $cemeterys,
            'form' => $form->createView(),
        ]);        
    }

    public function checkAlreadyExists(Cemetery $cemetery) {
        $cemetery = $this->repo->findOneBy([
            'name' => $cemetery->getName(),
        ]);
        if ($cemetery === null) {
            return false;
        }
        return true;
    }

    private function createGraves(Cemetery $cemetery, array $data): array {
        $graves = [];
        $rows = $data['high'];
        $columns = $data['width'];
        $letter = $data['letter'];
        /** @var GraveType $type */
        $type = $data['type'];
        for ($i = 1; $i <= $rows; $i++ ) {
            for ($j = 1; $j <= $columns; $j++ ) {
                if ($type->getId() === GraveType::OCUPATION || $type->getId() === GraveType::PANTEON ) {
                    $grave = new Grave();
                    $grave->setType($type);
                    $grave->setCemetery($cemetery);
                    $grave->setFree(true);
                    // $grave->setDescription($type->getDescriptionEs());
                    $code = $letter.'-'.str_pad($i,2,0,STR_PAD_LEFT).'-'.str_pad($j,2,0,STR_PAD_LEFT);
                    $grave->setCode($code);
                    $this->em->persist($grave);
                } else {
                    // DUST AND REST graves have an extra letter.
                    for ($k = 'A'; $k <= 'D'; $k++ ) {
                        $grave = new Grave();
                        $grave->setType($type);
                        $grave->setCemetery($cemetery);
                        $grave->setFree(true);
                        // $grave->setDescription($type->getDescriptionEs());
                        $code = $letter.'-'.str_pad($i,2,0,STR_PAD_LEFT).'-'.str_pad($j,2,0,STR_PAD_LEFT).'-'.$k;
                        $grave->setCode($code);
                        $this->em->persist($grave);
                    }
                }
                $graves[] = $grave;
            }
        }
        return $graves;
    }

    private function checkLetterAlreadyExists(Cemetery $cemetery, $letter) {
        $graves = $this->graveRepo->findByCemeteryAndLetter($cemetery, $letter);
        if (count($graves) > 0) {
            return true;
        }
        return false;
    }

    private function checkRemovable($graves) {
        return !$this->hasElements($graves);
    }
}
