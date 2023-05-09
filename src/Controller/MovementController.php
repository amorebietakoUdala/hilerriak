<?php

namespace App\Controller;

use App\Entity\DestinationType;
use App\Entity\Movement;
use App\Entity\MovementType;
use App\Form\MovementFormType;
use App\Form\MovementSearchFormType;
use App\Repository\AdjudicationRepository;
use App\Repository\DestinationTypeRepository;
use App\Repository\GraveRepository;
use App\Repository\MovementRepository;
use App\Repository\MovementTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatableMessage;

/**
 * @Route("/{_locale}")
 */
class MovementController extends BaseController
{

    private EntityManagerInterface $em;
    private MovementRepository $repo;
    private MovementTypeRepository $movementTypeRepo;
    private AdjudicationRepository $adjudicationRepo;
    private DestinationTypeRepository $destinationTypeRepo;
    private GraveRepository $graveRepo;
    private MailerInterface $mailer;

    public function __construct(
        EntityManagerInterface $em, 
        MovementRepository $repo, 
        MovementTypeRepository $movementTypeRepo, 
        DestinationTypeRepository $destinationTypeRepo, 
        GraveRepository $graveRepo, 
        MailerInterface $mailer,
        AdjudicationRepository $adjudicationRepo
    )
    {
        $this->em = $em;
        $this->repo = $repo;
        $this->movementTypeRepo = $movementTypeRepo;
        $this->destinationTypeRepo = $destinationTypeRepo;
        $this->graveRepo = $graveRepo;
        $this->mailer = $mailer;
        $this->adjudicationRepo = $adjudicationRepo;
    }

    /**
     * @Route("/movement/new", name="movement_new")
     */
    public function new(Request $request): Response 
    {
        $this->loadQueryParameters($request);
        $adjudicationId = $request->get('adjudication');
        $movement = new Movement();
        if ($adjudicationId) {
            $adjudication = $this->adjudicationRepo->find($adjudicationId);
            $movement->setDestinationType($this->destinationTypeRepo->find(DestinationType::DESTINATION_TYPE_GRAVE));
            $movement->setDestination($adjudication->getGrave());
        }
        $form = $this->createForm(MovementFormType::class, $movement,[
            'locale' => $request->getLocale(),
            'new' => true,
            'readonly' => false,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Movement $data */
            $data = $form->getData();
            $error = $this->checkErrors($data);
            if ($error) {
                return $this->renderTemplate($request,'_form.html.twig' , 'edit.html.twig', $form, [
                    'new' => true,
                    'readonly' => false,
                ]);
            }
            $data->setYear(($data->getDeceaseDate())->format('Y'));
            $data->setFinalized(false);
            $this->em->persist($data);
            $this->em->flush();
            $this->addFlash('success', 'messages.movementSaved');
            $this->sendMessage(
                'Mugimendu berria sortu da / Se ha creado un nuevo movimiento', 
                [$this->getParameter('mailer_undertaker')], 
                $data,
                'movement/newMovementMail.html.twig'
            );
            return $this->redirectToRoute('movement_index');
        }
        return $this->renderTemplate($request,'_form.html.twig' , 'edit.html.twig', $form, [
            'new' => true,
            'readonly' => false,
        ]);
    }

    /**
     * @Route("/movement/{movement}", name="movement_show")
     */
    public function show(Request $request, Movement $movement) {
        $this->loadQueryParameters($request);
        $form = $this->createForm(MovementFormType::class, $movement,[
            'locale' => $request->getLocale(),
            'new' => false,
            'readonly' => true,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Movement $data */
            $data = $form->getData();
            $data->setYear(($data->getDeceaseDate())->format('Y'));
            $this->em->persist($data);
            $this->em->flush();
            $this->addFlash('success', 'messages.movementSaved');
            return $this->redirectToRoute('movement_index');
        }
        return $this->renderTemplate($request,'_form.html.twig' , 'edit.html.twig', $form, [
            'new' => false,
            'readonly' => true,
        ]);
    }

    /**
     * @Route("/movement/{movement}/edit", name="movement_edit")
     */
    public function edit(Request $request, Movement $movement) {
        $this->loadQueryParameters($request);
        $form = $this->createForm(MovementFormType::class, $movement,[
            'locale' => $request->getLocale(),
            'new' => false,
            'readonly' => false,
        ]);
        $isFinalized = $movement->isFinalized();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Movement $data */
            $data = $form->getData();
            $data->setYear(($data->getDeceaseDate())->format('Y'));
            if (!$isFinalized && $data->isFinalized()) {
                // Movement finished so grave we must update Graves
                $this->updateGraves($data);
                // TODO Send message to bulego teknikoa
                $this->sendMessage(
                    'Hurrengo mugimendua bukatu egin da / El siguiente movimiento se ha finalizado', 
                    [$this->getParameter('mailer_technical_office')], 
                    $data,
                    'movement/movementFinishedMail.html.twig'
                );
            }
            $this->em->persist($data);
            $this->em->flush();
            $this->addFlash('success', 'messages.movementSaved');
            return $this->redirectToRoute('movement_index');
        }
        return $this->renderTemplate($request,'_form.html.twig' , 'edit.html.twig', $form, [
            'new' => false,
            'readonly' => false,
        ]);
    }

    /**
     * @Route("/movement/{movement}/delete", name="movement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Movement $movement) {
        $this->loadQueryParameters($request);
        if ($this->isCsrfTokenValid('delete'.$movement->getId(), $request->get('_token'))) {
            $this->em->remove($movement);
            $this->em->flush();
            if (!$request->isXmlHttpRequest() && !$this->getAjax()) {
                return $this->redirectToRoute('movement_index');
            } else {
                return new Response(null, 204);
            }
        } else {
            return new Response('messages.invalidCsrfToken', 422);
        }
    }

    /**
     * @Route("/movement", name="movement_index")
     */
    public function index(Request $request) {
        $this->loadQueryParameters($request);
        $criteria = $request->query->all();
        unset($criteria['page'],$criteria['pageSize'],$criteria['sortName'],$criteria['sortOrder'],$criteria['adjudication']);
        $movementSearchForm = $this->loadSearchForm($criteria);
        $movements = [];
        $form = $this->createForm(MovementSearchFormType::class, $movementSearchForm,[
            'locale' => $request->getLocale(),
            'readonly' => false,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Movement $data */
            $data = $form->getData();
            $criteriaWithoutBlanks = $this->removeBlankFilters($data);
            $movements = $this->repo->findByCriteria($criteriaWithoutBlanks, null, $this->getParameter('max_movements'), null);
        }
        if ($request->getMethod() === 'GET') {
            $movements = $this->repo->findBy($movementSearchForm, [ 'id' => 'desc' ], $this->getParameter('max_movements'));
        }
        if (count($movements) === $this->getParameter('max_movements')) {
            $this->addFlash('warning', new TranslatableMessage('messages.maxMovementsReached',[
                '{maxMovements}' => $this->getParameter('max_movements'),
            ]));
        }
        return $this->renderTemplate($request,'_list.html.twig', 'index.html.twig', $form, [
            'movements' => $movements,
            'new' => false,
            'readonly' => false,
        ]);
    }

    private function updateGraves(Movement $movement) {
        // TODO Sometimes it may depend on grave type.
        if ($movement->getType() === MovementType::MOVEMENT_TYPE_INHUMATION) {
            $destination = $movement->getDestination();
            $destination->setFree(false);
            $this->em->persist($destination);
            return;
        }
        if ($movement->getType() === MovementType::MOVEMENT_TYPE_EXHUMATION) {
            $source = $movement->getSource();
            $source->setFree(true);
            $this->em->persist($source);
            return;
        }
        if ($movement->getType() === MovementType::MOVEMENT_TYPE_INCINERATION || MovementType::MOVEMENT_TYPE_TRANSFER) {
            $destination = $movement->getDestination();
            $source = $movement->getSource();
            if ($destination !== null) {
                $destination->setFree(false);
                $this->em->persist($destination);
            }
            if ($source !== null) {
                $source->setFree(true);
                $this->em->persist($source);
            }
            return;
        }
        return;
    }

    private function sendMessage($subject, array $to, Movement $movement, $template = null)
    {

        $email = (new Email())
            ->from($this->getParameter('mailer_from'))
            ->to(...$to)
            ->subject($subject);
        if ($template) {
            $email->html($this->renderView($template, [
                'movement' => $movement,
            ]));
        } else {
            $email->html($this->renderView('movement/movementFinishedMail.html.twig', [
                'movement' => $movement,
            ]));
        }
        if ( $this->getParameter('sendBCC') ) {
            $addresses = [$this->getParameter('mailerBCC')];
            foreach ($addresses as $address) {
                $email->addBcc($address);
            }
        }            
        $this->mailer->send($email);
    }

    private function checkErrors(Movement $movement): bool {
        if ($movement->getType()->getId() == MovementType::MOVEMENT_TYPE_INHUMATION && 
            $movement->getDestinationType()->getId() == DestinationType::DESTINATION_TYPE_GRAVE 
            && $movement->getDestination() === null
            ) {
            $this->addFlash('error','messages.inhumationRequiresDestination');
            return true;
        }
        if ($movement->getDestinationType()->getId() == DestinationType::DESTINATION_TYPE_GRAVE && $movement->getDestination() === null) {
            $this->addFlash('error','messages.graveRequired');
            return true;
        }
        return false;
    }

    private function loadSearchForm(array $criteria): array {
        $movementSearchForm = $criteria;
        if (isset($movementSearchForm['source'])) {
            $movementSearchForm['source'] = ($this->graveRepo->find($movementSearchForm['source']));
        }
        if (isset($movementSearchForm['destination'])) {
            $movementSearchForm['destination'] = ($this->graveRepo->find($movementSearchForm['destination']));
        }
        if (isset($movementSearchForm['type'])) {
            $movementSearchForm['type'] = ($this->movementTypeRepo->find($movementSearchForm['type']));
        }
        return $movementSearchForm;
    }

    private function renderTemplate(Request $request, $ajaxTemplate, $noAjaxTemplate, $form, array $parameters = []) {
        $template = $this->getAjax() || $request->isXmlHttpRequest() ? $ajaxTemplate : $noAjaxTemplate;
        return $this->renderForm('movement/' . $template, array_merge([
            'form' => $form,
        ], $parameters),  new Response(null, $form->isSubmitted() && ( !$form->isValid() )? 422 : 200));        
    }
}
