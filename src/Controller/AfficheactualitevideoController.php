<?php

namespace App\Controller;

use App\Entity\Actualitevideo;
use App\Repository\ActualitevideoRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;


class AfficheactualitevideoController extends AbstractController
{
    #[Route('/Actualitevideo', name: 'app_afficheactualitevideo')]
    public function index(actualitevideoRepository $ActualitevideoRepository , Request $request, EntityManagerInterface $entityManager): Response
    {


  // Récupérer le numéro de la page de la requête, par défaut page 1
 $page = max(1, $request->query->getInt('page', 1));
 $limit = 3; // Nombre de jeux à afficher par page

 // Requête paginée
 $query = $entityManager->createQuery(
     'SELECT j FROM App\Entity\Actualitevideo  j ORDER BY j.createAd DESC'
 )
 ->setFirstResult(($page - 1) * $limit)  // Calculer l'offset
 ->setMaxResults($limit);                // Limiter le nombre de résultats

 // Pagination
 $paginator = new Paginator($query, true);
 $totalGames = count($paginator);  // Nombre total de jeux
 $totalPages = ceil($totalGames / $limit);  // Calculer le nombre total de pages





        // $allactualitevideo = $ActualitevideoRepository->findAll(); // Cette méthode récupère tous les jeux de la table
        return $this->render('afficheactualitevideo/index.html.twig', [
            'controller_name' => 'AfficheactualitevideoController',
            // 'allactualitevideo' => $allactualitevideo,  
            'allactualitevideo' => $paginator,
            'page' => $page,
            'totalPages' => $totalPages,
        ]);
    }

    #[Route('/video/{id}/delete', name: 'actualitevideo_delete', methods: ['POST'])]
    public function delete(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        // Utilisation de EntityManagerInterface pour récupérer l'entité Actuc
        $actuc = $entityManager->getRepository(Actualitevideo::class)->find($id);

        if (!$actuc) {
            throw $this->createNotFoundException('Le video avec l\'ID ' . $id . ' n\'existe pas.');
        }

        // CSRF validation
        if ($this->isCsrfTokenValid('delete' . $actuc->getId(), $request->request->get('_token'))) {
            $entityManager->remove($actuc);
            $entityManager->flush();
            $this->addFlash('success', 'video supprimé avec succès!');
        }

        return $this->redirectToRoute('app_listeactualitevideo');
    }
}
