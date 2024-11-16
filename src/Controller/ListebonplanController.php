<?php

namespace App\Controller;


use App\Repository\BonplanRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListebonplanController extends AbstractController
{
    #[Route('/listebonplan', name: 'app_listebonplan')]
    public function index(bonplanRepository $bonplanRepository): Response
    {

        $allbonplan = $bonplanRepository->findAll(); // Cette méthode récupère tous les jeux de la table
        return $this->render('listebonplan/index.html.twig', [
            'controller_name' => 'ListebonplanController',
            'allbonplan' => $allbonplan, // Passe la liste des jeux à la vue
        ]);
    }
}
