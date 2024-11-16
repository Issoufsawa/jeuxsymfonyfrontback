<?php

namespace App\Controller;

use App\Repository\ActucRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AfficherjeuxController extends AbstractController
{
    #[Route('/afficherjeux', name: 'app_afficherjeux')]
    public function index(actucRepository $actucRepository): Response
    {
        $jeux = $actucRepository->findAll(); // Cette méthode récupère tous les jeux de la table
        return $this->render('afficherjeux/index.html.twig', [
            'controller_name' => 'AfficherjeuxController',
            'jeux' => $jeux, // Passe la liste des jeux à la vue
        ]);
    }
}
