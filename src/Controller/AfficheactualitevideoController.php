<?php

namespace App\Controller;

use App\Repository\ActualitevideoRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AfficheactualitevideoController extends AbstractController
{
    #[Route('/afficheactualitevideo', name: 'app_afficheactualitevideo')]
    public function index(actualitevideoRepository $ActualitevideoRepository): Response
    {
        $allactualitevideo = $ActualitevideoRepository->findAll(); // Cette méthode récupère tous les jeux de la table
        return $this->render('afficheactualitevideo/index.html.twig', [
            'controller_name' => 'AfficheactualitevideoController',
            'allactualitevideo' => $allactualitevideo,  
        ]);
    }
}
