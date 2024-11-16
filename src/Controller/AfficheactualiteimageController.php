<?php

namespace App\Controller;

use App\Repository\ActualiteimageRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AfficheactualiteimageController extends AbstractController
{
    #[Route('/afficheactualiteimage', name: 'app_afficheactualiteimage')]
    public function index(actualiteimageRepository $ActualiteimageRepository): Response
    {
        $allactualiteimage = $ActualiteimageRepository->findAll(); // Cette méthode récupère tous les jeux de la table
        return $this->render('afficheactualiteimage/index.html.twig', [
            'controller_name' => 'AfficheactualiteimageController',
            'allactualiteimage' => $allactualiteimage,  
        ]);
    }
}
