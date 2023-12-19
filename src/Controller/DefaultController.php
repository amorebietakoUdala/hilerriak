<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_HILERRIAK')]
class DefaultController extends AbstractController
{

   #[Route(path: '/', name: 'app_home')]
   public function home() : Response
   {
       if ($this->isGranted("ROLE_UNDERTAKER")) {
          return $this->redirectToRoute('movement_index',[
             'finalized' => false,
          ]);
       }
       if ($this->isGranted("ROLE_TECHNICAL_OFFICE")) {
          return $this->redirectToRoute('movement_index',[
             'finalized' => true,
          ]);
       }
       return $this->redirectToRoute('owner_index');
   }
}