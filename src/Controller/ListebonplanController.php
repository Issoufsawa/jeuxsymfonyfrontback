<?php

namespace App\Controller;


use App\Entity\Bonplan;
use App\Form\BonplanType;
use App\Repository\BonplanRepository; // Importe le repository de l'entité
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

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
    #[Route('/bonplan/{id}/edit', name: 'bonplan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'entité Actuc par son ID
        $actuc = $entityManager->getRepository(Bonplan::class)->find($id);
    
        if (!$actuc) {
            throw $this->createNotFoundException('Le bonplan avec l\'ID ' . $id . ' n\'existe pas.');
        }
    
        $form = $this->createForm(BonplanType::class, $actuc);
        $form->handleRequest($request);
    
        // Traitement du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion des fichiers, sauvegarde, redirection...
        }
            // Création du formulaire pour l'édition de l'entité
    $form = $this->createForm(BonplanType::class, $actuc);
    $form->handleRequest($request);

    // Traitement du formulaire une fois soumis
    if ($form->isSubmitted() && $form->isValid()) {
        // Vérification de l'upload de l'image
        $imageFile = $form->get('image')->getData();
        if ($imageFile) {
            $newFilename = uniqid() . '.' . $imageFile->guessExtension();
// Déplacement de l'image dans le répertoire configuré
            $imageFile->move(
                $this->getParameter('images_directory'), // Assurez-vous que ce paramètre est défini dans `services.yaml`
                $newFilename
            );

            // Mise à jour du chemin de l'image dans l'entité
            $actuc->setImagePath($newFilename);
        }
        // Sauvegarde des modifications dans la base de données
        $entityManager->flush();

        // Ajout d'un message flash pour indiquer que la modification a été réussie
        $this->addFlash('success', 'bonplan modifié avec succès!'); 
// Redirection vers la liste des jeux    
return $this->redirectToRoute('app_listebonplan');
    }

        return $this->render('bonplan/edit.html.twig', [
            'form' => $form->createView(),
            'bonplan' => $actuc,
        ]);
    }

    #[Route('/bonplan/{id}/delete', name: 'bonplan_delete', methods: ['POST'])]
    public function delete(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        // Utilisation de EntityManagerInterface pour récupérer l'entité Actuc
        $actuc = $entityManager->getRepository(Bonplan::class)->find($id);

        if (!$actuc) {
            throw $this->createNotFoundException('Le bonplan avec l\'ID ' . $id . ' n\'existe pas.');
        }

        // CSRF validation
        if ($this->isCsrfTokenValid('delete' . $actuc->getId(), $request->request->get('_token'))) {
            $entityManager->remove($actuc);
            $entityManager->flush();
            $this->addFlash('success', 'bonplan supprimé avec succès!');
        }

        return $this->redirectToRoute('app_listebonplan');
    }
}

