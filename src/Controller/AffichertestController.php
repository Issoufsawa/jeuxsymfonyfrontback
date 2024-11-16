<?php

namespace App\Controller;

use App\Repository\TestRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AffichertestController extends AbstractController
{
    #[Route('/affichertest', name: 'app_affichertest')]
    public function index(testRepository $testRepository): Response
    {
        $alltest = $testRepository->findAll(); // Cette méthode récupère tous les jeux de la table
        return $this->render('affichertest/index.html.twig', [
            'controller_name' => 'AffichertestController',
            'alltest' =>  $alltest, // Passe la liste des jeux à la vue
        ]);
    }
}
