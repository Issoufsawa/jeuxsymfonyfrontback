<?php

namespace App\Controller;

use App\Repository\ActucRepository; // Importe le repository de l'entité
use App\Repository\VideoRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Actualite1Controller extends AbstractController
{
    #[Route('/actualite1', name: 'app_actualite1')]
    public function index(actucRepository $actucRepository,videoRepository $videoRepository): Response
    {
        $jeux = $actucRepository->findAll(); // Cette méthode récupère tous les jeux de la table
        $video = $videoRepository->findAll(); // Cette méthode récupère toutes les videos de la table
        return $this->render('actualite1/index.html.twig', [
            'controller_name' => 'Actualite1Controller',
            'video' => $video, // Passe la liste des jeux à la vue
            'jeux' => $jeux, // Passe la liste des jeux à la vue
        ]);
    }
}
