<?php

namespace App\Controller;

use App\Entity\Actualitevideo;
use App\Repository\ActualitevideoRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class AfficheactualitevideoController extends AbstractController
{
    #[Route('/afficheactualitevideo', name: 'app_afficheactualitevideo')]
    public function index(actualitevideoRepository $ActualitevideoRepository): Response
    {
        $allactualitevideo = $ActualitevideoRepository->findAll(); // Cette méthode récupère tous les jeux de la table
        return $this->render('afficheactualitevideo/index.html.twig', [
            'controller_name' => 'AfficheactualitevideoController',
            'allactualitevideo' => $allactualitevideo,  
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
