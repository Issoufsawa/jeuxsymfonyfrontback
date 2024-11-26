<?php

namespace App\Controller;

use App\Repository\VideoRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AffichervideoController extends AbstractController
{
    #[Route('/affichervideo', name: 'app_affichervideo')]
    public function index(videoRepository $videoRepository , Request $request, EntityManagerInterface $entityManager): Response
    {


        
 // Récupérer le numéro de la page de la requête, par défaut page 1
 $page = max(1, $request->query->getInt('page', 1));
 $limit = 3; // Nombre de jeux à afficher par page

 // Requête paginée
 $query = $entityManager->createQuery(
     'SELECT j FROM App\Entity\Video  j ORDER BY j.createAd DESC'
 )
 ->setFirstResult(($page - 1) * $limit)  // Calculer l'offset
 ->setMaxResults($limit);                // Limiter le nombre de résultats

 // Pagination
 $paginator = new Paginator($query, true);
 $totalGames = count($paginator);  // Nombre total de jeux
 $totalPages = ceil($totalGames / $limit);  // Calculer le nombre total de pages


        // $video = $videoRepository->findAll(); // Cette méthode récupère toutes les videos de la table
        return $this->render('affichervideo/index.html.twig', [
            'controller_name' => 'AffichervideoController',
            // 'video' => $video, // Passe la liste des jeux à la vue
            'video'  => $paginator,
            'page' => $page,
            'totalPages' => $totalPages,

        ]);
    }
}
