<?php

namespace App\Controller;

use App\Repository\ActucRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class AfficherjeuxController extends AbstractController
{
    #[Route('/afficherjeux', name: 'app_afficherjeux')]
    public function index(actucRepository $actucRepository , Request $request, EntityManagerInterface $entityManager): Response
    {

        
 // Récupérer le numéro de la page de la requête, par défaut page 1
 $page = max(1, $request->query->getInt('page', 1));
 $limit = 3; // Nombre de jeux à afficher par page

 // Requête paginée
 $query = $entityManager->createQuery(
     'SELECT j FROM App\Entity\Actuc  j ORDER BY j.createAd DESC'
 )
 ->setFirstResult(($page - 1) * $limit)  // Calculer l'offset
 ->setMaxResults($limit);                // Limiter le nombre de résultats

 // Pagination
 $paginator = new Paginator($query, true);
 $totalGames = count($paginator);  // Nombre total de jeux
 $totalPages = ceil($totalGames / $limit);  // Calculer le nombre total de pages


        // $jeux = $actucRepository->findAll(); // Cette méthode récupère tous les jeux de la table
        return $this->render('afficherjeux/index.html.twig', [
            'controller_name' => 'AfficherjeuxController',
            // 'jeux' => $jeux, // Passe la liste des jeux à la vue

            'jeux' => $paginator,
            'page' => $page,
            'totalPages' => $totalPages,

        ]);
    }
}
