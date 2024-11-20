<?php

namespace App\Controller;

use App\Entity\Appointement;
use App\Repository\AppointementRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class AppointementadminController extends AbstractController
{
    #[Route('/appointementadmin', name: 'app_appointementadmin')]
    public function index(appointementRepository $appointementRepository): Response
    {   
        $alltest = $appointementRepository->findAll(); // Cette méthode récupère tous les jeux de la table
        return $this->render('appointementadmin/index.html.twig', [
            'controller_name' => 'AppointementadminController',
            'alltest' => $alltest, 
        ]);
    }


    
    #[Route('/appointement/{id}/delete', name: 'appointement_delete', methods: ['POST'])]
    public function delete(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        // Utilisation de EntityManagerInterface pour récupérer l'entité Actuc
        $actuc = $entityManager->getRepository(Appointement::class)->find($id);

        if (!$actuc) {
            throw $this->createNotFoundException('Le rendez-vous avec l\'ID ' . $id . ' n\'existe pas.');
        }

        // CSRF validation
        if ($this->isCsrfTokenValid('delete' . $actuc->getId(), $request->request->get('_token'))) {
            $entityManager->remove($actuc);
            $entityManager->flush();
            $this->addFlash('success', 'rendez-vous supprimé avec succès!');
        }

        return $this->redirectToRoute('app_appointementadmin');
    }
}
