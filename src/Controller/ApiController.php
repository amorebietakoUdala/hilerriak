<?php

namespace App\Controller;

use App\Repository\AdjudicationRepository;
use App\Repository\CemeteryRepository;
use App\Repository\OwnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_HILERRIAK')]
class ApiController extends AbstractController
{

   public function __construct(
      private readonly CemeteryRepository $cemeteryRepo, 
      private readonly OwnerRepository $ownerRepo, 
      private readonly AdjudicationRepository $adjudicationRepo)
   {
   }

   #[Route(path: '/api/cemetery/graves', name: 'api_graves_service')]
   public function gravesService(Request $request): Response
   {
      $graves = [];
      $cemetery = $request->get('cemetery');
      if ($cemetery === null) {
         return $this->json($graves);
      }
      $cemetery = $this->cemeteryRepo->find($cemetery);
      return $this->json($cemetery->getGraves(),200,[],[
         'groups' => 'api_graves',
      ]);
   }

   #[Route(path: '/api/owners/cemetery', name: 'api_owners_cemetery')]
   public function getOwnersByCemetery(Request $request): Response
   {
      $owners = [];
      $cemetery = $request->get('cemetery');
      if ($cemetery === null) {
         return $this->json($owners);
      }
      $owners = $this->adjudicationRepo->findByCemetery($cemetery);
      return $this->json($owners,200,[],[
         'groups' => 'api_person',
      ]);
   }
}