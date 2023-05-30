<?php

namespace App\Controller;

use App\Form\HistoryMovementsType;
use App\Repository\HistoryMovementsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{_locale}")
 */
class HistoryMovementsController extends BaseController
{

    private HistoryMovementsRepository $hmRepo;

    public function __construct(HistoryMovementsRepository $hmRepo)
    {
        $this->hmRepo = $hmRepo;
    }

    /**
     * @Route("/history/movements", name="historyMovement_index")
     */
    public function index(Request $request): Response
    {
        $this->loadQueryParameters($request);
        $historyMovements = [];

        $form = $this->createForm(HistoryMovementsType::class, null,[
            'readonly' => false,
            'locale' => $request->getLocale(),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $criteria = $form->getData();
            $criteria = $this->removeBlankFilters($criteria);
            $historyMovements = $this->hmRepo->findByCriteria($criteria);
        }

        return $this->renderForm('history_movements/index.html.twig', [
            'historyMovements' => $historyMovements,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/history/movements/{historyMovement}", name="historyMovement_show")
     */
    public function show(Request $request): Response
    {
        dd($request);
        $this->loadQueryParameters($request);
        $historyMovements = $this->hmRepo->findAll();

        $form = $this->createForm(historyMovementsType::class, null,[
            'readonly' => false,
            'locale' => $request->getLocale(),
        ]);
        return $this->renderForm('history_movements/index.html.twig', [
            'historyMovements' => $historyMovements,
            'form' => $form,
        ]);
    }

}
