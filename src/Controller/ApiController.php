<?php

namespace App\Controller;

use App\Entity\Adjudication;
use App\Entity\Cemetery;
use App\Form\AdjudicationAddFormType;
use App\Form\AdjudicationEditFormType;
use App\Repository\AdjudicationRepository;
use App\Repository\CemeteryRepository;
use App\Repository\OwnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/** 
* @IsGranted("ROLE_HILERRIAK")
*/
class ApiController extends AbstractController
{

   private CemeteryRepository $cemeteryRepo;
   private OwnerRepository $ownerRepo;
   private AdjudicationRepository $adjudicationRepo;

   public function __construct(CemeteryRepository $cemeteryRepo, OwnerRepository $ownerRepo, AdjudicationRepository $adjudicationRepo)
   {
      $this->cemeteryRepo = $cemeteryRepo;
      $this->ownerRepo = $ownerRepo;
      $this->adjudicationRepo = $adjudicationRepo;
   }

   /**
    * @Route("/api/cemetery/graves", name="api_graves_service")
    */
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

   /**
    * @Route("/api/owners/cemetery", name="api_owners_cemetery")
    */
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

   // /**
   //  * @Route("/api/owner/fullname", name="api_owner_get_fullname")
   //  */
   //  public function getOwnerByFullname(Request $request): Response
   //  {
   //     $owners = [];
   //     $fullname = $request->get('fullname');
   //     if ($fullname === null) {
   //        return $this->json($owners);
   //     }
   //     $owners = $this->ownerRepo->findByFullname($fullname);
   //     return $this->json($owners,200,[],[
   //        'groups' => 'api_person',
   //     ]);
   //  }
}