<?php

namespace App\Controller;

use App\Repository\BonplanRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AfficherbonplanController extends AbstractController
{
    #[Route('/afficherbonplan', name: 'app_afficherbonplan')]
    public function index(bonplanRepository $bonplanRepository): Response
    {
        $allbonplan = $bonplanRepository->findAll(); // Cette méthode récupère tous les jeux de la table
        return $this->render('afficherbonplan/index.html.twig', [
            'controller_name' => 'AfficherbonplanController',
            'allbonplan' =>  $allbonplan, // Passe la liste des jeux à la vue
        ]);
    }
}
