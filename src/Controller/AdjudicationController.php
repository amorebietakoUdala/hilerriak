<?php

namespace App\Controller;

use App\Entity\Adjudication;
use App\Entity\Grave;
use App\Form\AdjudicationAddFormType;
use App\Form\AdjudicationEditFormType;
use App\DTO\AdjudicationSearchFormDTO;
use App\Form\AdjudicationSearchFormType;
use App\Repository\AdjudicationRepository;
use App\Repository\CemeteryRepository;
use App\Repository\GraveRepository;
use App\Repository\OwnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Mailer\MailerInterface;

class AdjudicationController extends BaseController
{

    private EntityManagerInterface $em;
    private AdjudicationRepository $repo;
    private CemeteryRepository $cemeteryRepo;
    private OwnerRepository $ownerRepo;
    private GraveRepository $graveRepo;
    // private TranslatorInterface $translator;
    // private MailerInterface $mailer;

    public function __construct(
        EntityManagerInterface $em, 
        AdjudicationRepository $repo, 
        CemeteryRepository $cemeteryRepo, 
        OwnerRepository $ownerRepo, 
        GraveRepository $graveRepo 
        // TranslatorInterface $translator,
        // MailerInterface $mailer
    ) {
        $this->em = $em;
        $this->repo = $repo;
        $this->cemeteryRepo = $cemeteryRepo;
        $this->ownerRepo = $ownerRepo;
        $this->graveRepo = $graveRepo;
        // $this->translator = $translator;
        // $this->mailer = $mailer;
    }

    /**
     * @Route("/{_locale}/adjudication/new", name="adjudication_new")
     */
    public function new(Request $request): Response
    {
        $this->loadQueryParameters($request);
        $data = $this->initializeForm($request->query->all());
        $form = $this->createForm(AdjudicationAddFormType::class, $data,[            
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $data = $form->getData();
            // $addMovement = boolval($data['addMovement']);
            // unset($data['addMovement']);
            $adjudication = new Adjudication();
            $adjudication->fill($data);
            $year = intval((new \DateTime())->format('Y'));
            $adjudication->setAdjudicationYear($year);
            if ($adjudication->getGrave()->getYears() !== null) {
                $adjudication->setExpiryYear($year+$adjudication->getGrave()->getYears());
            }
            $this->removeAdjucationsForGrave($adjudication->getGrave());
            $this->em->persist($adjudication);
            $this->em->flush();
            // No need to send email on adjudication, it will be notified through AUPAC
            //$this->sendMessage('Hilobi berria adjudikatu da / Se ha adjudicado una nueva sepultura', [$this->getParameter('mailer_technical_office')], $adjudication );
            $this->addFlash('success', 'messages.adjudicationSaved');
            // if (!$addMovement) {
            // return $this->redirectToRoute('adjudication_index');
            // } else {
            return parent::redirect($this->generateUrl('movement_new',[
                'adjudication' => $adjudication->getId(),
            ]));
            // }
        }
        return $this->renderForm('adjudication/edit.html.twig',[
            'form' => $form,
            'new' => true,
            'readonly' => false,
        ]);
    }

    /**
     * @Route("/{_locale}/adjudication/{adjudication}", name="adjudication_show")
     */
    public function show(Adjudication $adjudication, Request $request): Response 
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(AdjudicationEditFormType::class, $adjudication,[
            'readonly' => true,
        ]);
        $form->handleRequest($request);
        return $this->renderForm('adjudication/edit.html.twig',[
            'form' => $form,
            'new' => false,
            'readonly' => true,
        ]);
    }

    /**
     * @Route("/{_locale}/adjudication/{adjudication}/edit", name="adjudication_edit")
     */
    public function edit(Adjudication $adjudication, Request $request): Response 
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(AdjudicationEditFormType::class, $adjudication,[
            'readonly' => false,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            /** @var Adjudication $data */
            $data = $form->getData();
            $this->em->persist($data);
            $this->em->flush();
            $this->addFlash('success', 'messages.adjudicationSaved');
            return $this->redirectToRoute('adjudication_index');
        }
        return $this->renderForm('adjudication/edit.html.twig',[
            'form' => $form,
            'new' => false,
            'readonly' => false,
        ]);
    }

    /**
     * @Route("/{_locale}/adjudication/{adjudication}/delete", name="adjudication_delete", methods={"DELETE"})
     */
    public function delete(Adjudication $adjudication, Request $request): Response 
    {
        if ($this->isCsrfTokenValid('delete'.$adjudication->getId(), $request->get('_token'))) {
            $this->em->remove($adjudication);
            $this->em->flush();
            if (!$request->isXmlHttpRequest() && !$this->getAjax()) {
                return $this->redirectToRoute('adjudication_index');
            } else {
                return new Response(null, 204);
            }
        } else {
            return new Response('messages.invalidCsrfToken', 422);
        }
    }

    /**
     * @Route("/{_locale}/adjudication", name="adjudication_index")
     */
    public function index(Request $request): Response
    {
        $this->loadQueryParameters($request);
        $criteria = $request->query->all();
        unset($criteria['page'],$criteria['pageSize'],$criteria['sortName'],$criteria['sortOrder']);
        $adjudicationSearchForm = $this->loadSearchForm($criteria);
        $form = $this->createForm(AdjudicationSearchFormType::class, $adjudicationSearchForm,[]);
        $adjudications = [];
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            /** @var AdjudicationSearchFormDTO $criteria */
            $data = $form->getData();
            $criteria = $data->toArray();
            $adjudications = $this->repo->findByCriteria($criteria,['id' => 'DESC']);
        }
        if ($request->getMethod() === 'GET') {
            $adjudications = $this->repo->findByCriteria($criteria,['id' => 'DESC'],$this->getParameter('max_adjudications'));
        }
        if (count($adjudications) === $this->getParameter('max_adjudications')) {
            $this->addFlash('warning', new TranslatableMessage('messages.maxAdjudicationsReached',[
                '{maxAdjudications}' => $this->getParameter('max_adjudications'),
            ]));
        }        
        $template = !$this->getAjax() ? 'adjudication/index.html.twig' : 'adjudication/_list.html.twig';
        return $this->renderForm($template, [
            'adjudications' => $adjudications,
            'form' => $form,
        ]);                
    }

    private function loadSearchForm($criteria): AdjudicationSearchFormDTO {
        $adjudicationSearchForm = new AdjudicationSearchFormDTO();
        if (isset($criteria['cemetery'])) {
            $adjudicationSearchForm->setCemetery($this->cemeteryRepo->find($criteria['cemetery']));
        }
        if (isset($criteria['owner'])) {
            $adjudicationSearchForm->setOwner($this->ownerRepo->find($criteria['owner']));
        }
        if (isset($criteria['grave'])) {
            $adjudicationSearchForm->setGrave($this->graveRepo->find($criteria['grave']));
        }
        if (isset($criteria['expired'])) {
            $adjudicationSearchForm->setGrave($this->graveRepo->find($criteria['expired']));
        }
        return $adjudicationSearchForm;
    }

    private function initializeForm(array $data) {
        $formValues = [];
        if (isset($data['owner'])) {
            $formValues['owner']=$this->ownerRepo->find($data['owner']);
        }
        if (isset($data['grave'])) {
            $formValues['grave']=$this->ownerRepo->find($data['grave']);
        }
        return $formValues;
    }

    private function removeAdjucationsForGrave(Grave $grave) {
        $adjudications = $grave->getAdjudications();
        foreach($adjudications as $adjudication) {
            $this->em->remove($adjudication);
        }
    }

    // private function sendMessage($subject, array $to, Adjudication $adjudication, $template = null)
    // {

    //     $email = (new Email())
    //         ->from($this->getParameter('mailer_from'))
    //         ->to(...$to)
    //         ->subject($subject);
    //     if ($template) {
    //         $email->html($this->renderView($template, [
    //             'adjudication' => $adjudication,
    //         ]));
    //     } else {
    //         $email->html($this->renderView('adjudication/graveAdjudicatedMail.html.twig', [
    //             'adjudication' => $adjudication,
    //         ]));
    //     }
    //     if ( $this->getParameter('sendBCC') ) {
    //         $addresses = [$this->getParameter('mailerBCC')];
    //         foreach ($addresses as $address) {
    //             $email->addBcc($address);
    //         }
    //     }            
    //     $this->mailer->send($email);
    // }
}
