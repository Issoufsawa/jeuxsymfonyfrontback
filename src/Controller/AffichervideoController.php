<?php

namespace App\Controller;

use App\Repository\VideoRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AffichervideoController extends AbstractController
{
    #[Route('/affichervideo', name: 'app_affichervideo')]
    public function index(videoRepository $videoRepository): Response
    {
        $video = $videoRepository->findAll(); // Cette méthode récupère toutes les videos de la table
        return $this->render('affichervideo/index.html.twig', [
            'controller_name' => 'AffichervideoController',
            'video' => $video, // Passe la liste des jeux à la vue
        ]);
    }
}
