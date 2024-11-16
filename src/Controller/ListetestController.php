<?php

namespace App\Controller;

use App\Repository\TestRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListetestController extends AbstractController
{
    #[Route('/listetest', name: 'app_listetest')]
    public function index(testRepository $testRepository): Response
    {
        $alltest = $testRepository->findAll(); // Cette méthode récupère tous les jeux de la table
        return $this->render('listetest/index.html.twig', [
            'controller_name' => 'ListetestController',
            'alltest' => $alltest, // Passe la liste des jeux à la vue
        ]);
    }
}
