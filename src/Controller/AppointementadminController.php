<?php

namespace App\Controller;

use App\Repository\AppointementRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppointementadminController extends AbstractController
{
    #[Route('/appointementadmin', name: 'app_appointementadmin')]
    public function index(appointementRepository $appointementRepository): Response
    {   
        $alltest = $appointementRepository->findAll(); // Cette méthode récupère tous les jeux de la table
        return $this->render('appointementadmin/index.html.twig', [
            'controller_name' => 'AppointementadminController',
            'alltest' => $alltest, 
        ]);
    }
}
