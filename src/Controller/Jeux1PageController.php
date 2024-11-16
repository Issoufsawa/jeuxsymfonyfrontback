<?php

namespace App\Controller;

use App\Repository\VideoRepository; // Importe le repository de l'entité
use App\Repository\ActucRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Jeux1PageController extends AbstractController
{
    #[Route('/jeux1/page', name: 'app_jeux1_page')]
    public function index(actucRepository $actucRepository,videoRepository $videoRepository): Response
    {

        $video = $videoRepository->findAll(); // Cette méthode récupère toutes les videos de la table
        $jeux = $actucRepository->findAll(); // Cette méthode récupère tous les jeux de la table
        return $this->render('jeux1_page/index.html.twig', [
            'controller_name' => 'Jeux1PageController',
            'jeux' => $jeux, // Passe la liste des jeux à la vue
            'video' => $video, // Passe la liste des jeux à la vue
        ]);
    }


   
}
