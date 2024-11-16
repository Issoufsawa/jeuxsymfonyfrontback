<?php

namespace App\Controller;

use App\Repository\ActualiteimageRepository; // Importe le repository de l'entité
use App\Repository\VideoRepository; // Importe le repository de l'entité
use App\Repository\ActucRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AfficheractualiteController extends AbstractController
{
    #[Route('/accueil', name: 'app_afficheractualite')]
    public function index(actucRepository $actucRepository ,videoRepository $videoRepository, actualiteimageRepository $actualiteimageRepository ): Response
    {
        $jeux = $actucRepository->findFirstthree(); // Cette méthode récupère  les jeux de la table
        $jeux5 = $actucRepository->findLastFive();
        $jeux4 = $actucRepository->findBy([], [], 1, 4);
        $jeux2 = $actucRepository->findBy([], [], 3, 5);
        $video = $videoRepository->findFirstOne(); // Cette méthode récupère des videos de la table
        $actualiteimage = $actualiteimageRepository->findAll(); // Cette méthode récupère les jeux de la table
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AfficheractualiteController',
            'jeux' => $jeux, // Passe la liste des jeux à la vue
            'jeux5' => $jeux5, // Passe la liste des jeux à la vue
            'jeux4' => $jeux4, // Passe la liste des jeux à la vue
            'jeux2' => $jeux2, // Passe la liste des jeux à la vue
            'video' => $video, // Passe la liste des jeux à la vue
            'actualiteimage' =>  $actualiteimage, // Passe la liste des jeux à la vue
        ]);
    }


    // #[Route('/detaille/{id}', name: 'app_detaille')]
    // public function detaille(int $id, actucRepository $actucRepository ): Response
    // {
    //     $detaille1 = $actucRepository->find($id);
    //     // $detaille1 = $this->getDoctrine()->getRepository(Actuc::class)->find($id);

    //     if (!$detaille1) {
    //         throw $this->createNotFoundException('Jeu non trouvé');
    //     }
    //     //  dd($detaille1);

    //     return $this->render('detaille/index.html.twig', [
    //         'controller_name' => 'DetailleController',
    //         'detaille1' => $detaille1,
    //     ]);
    // }
}
