<?php

namespace App\Controller;

use App\Repository\TestRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ListetestController extends AbstractController
{
    #[Route('/listetest', name: 'app_listetest')]
    public function index(TestRepository $testRepository, Request $request): Response
    {
        // Nombre d'éléments par page
        $limit = 3;
    
        // Récupérer la page actuelle (par défaut 1)
        $page = max(1, $request->query->getInt('page', 1));
    
        // Calcul de l'offset
        $offset = ($page - 1) * $limit;
    
        // Récupérer le total des enregistrements
        $total = $testRepository->count([]);
    
        // Récupérer les enregistrements paginés
        $alltest = $testRepository->findBy([], null, $limit, $offset);
    
        // Calculer le nombre total de pages
        $totalPages = ceil($total / $limit);
    
        // Renvoyer les données à la vue
        return $this->render('listetest/index.html.twig', [
            'alltest' => $alltest,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }
}
