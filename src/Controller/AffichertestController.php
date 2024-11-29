<?php

namespace App\Controller;

use App\Repository\TestRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AffichertestController extends AbstractController
{
    #[Route('/test', name: 'app_affichertest')]
    public function index(testRepository $testRepository , Request $request, EntityManagerInterface $entityManager): Response
    {


          
 // Récupérer le numéro de la page de la requête, par défaut page 1
 $page = max(1, $request->query->getInt('page', 1));
 $limit = 3; // Nombre de jeux à afficher par page

 // Requête paginée
 $query = $entityManager->createQuery(
     'SELECT j FROM App\Entity\Test  j ORDER BY j.createAd DESC'
 )
 ->setFirstResult(($page - 1) * $limit)  // Calculer l'offset
 ->setMaxResults($limit);                // Limiter le nombre de résultats

 // Pagination
 $paginator = new Paginator($query, true);
 $totalGames = count($paginator);  // Nombre total de jeux
 $totalPages = ceil($totalGames / $limit);  // Calculer le nombre total de pages




        // $alltest = $testRepository->findAll(); // Cette méthode récupère tous les jeux de la table
        return $this->render('affichertest/index.html.twig', [
            'controller_name' => 'AffichertestController',
            // 'alltest' =>  $alltest, // Passe la liste des jeux à la vue
            'alltest' => $paginator,
            'page' => $page,
            'totalPages' => $totalPages,

        ]);
    }
}
