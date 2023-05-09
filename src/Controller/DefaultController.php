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
use Symfony\Component\Security\Core\Security;

/** 
* @IsGranted("ROLE_HILERRIAK")
*/
class DefaultController extends AbstractController
{

   /**
    * @Route("/", name="app_home")
    */
   public function home(Request $request): Response
   {
      if ($this->isGranted("ROLE_UNDERTAKER")) {
         return $this->redirectToRoute('movement_index',[
            'finalized' => false,
         ]);
      }

      return $this->redirectToRoute('owner_index');
   }

   // /**
   //  * @Route("/api/owner/dni", name="api_owner_get_dni")
   //  */
   //  public function getOwnerByDni(Request $request): Response
   //  {
   //     $owners = [];
   //     $dni = $request->get('dni');
   //     if ($dni === null) {
   //        return $this->json($owners);
   //     }
   //     $owners = $this->ownerRepo->findByDni($dni);
   //     return $this->json($owners,200,[],[
   //        'groups' => 'api_owner',
   //     ]);
   //  }

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
   //        'groups' => 'api_owner',
   //     ]);
   //  }
}