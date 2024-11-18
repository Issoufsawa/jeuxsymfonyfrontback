<?php

namespace App\Controller;

use App\Entity\Test;
use App\Form\TestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        {
            $test = new Test();
            $form = $this->createForm(TestType::class, $test);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $imageFile = $form->get('image')->getData();
    
                if ($imageFile) {
                    $newFilename = uniqid() . '.' . $imageFile->guessExtension();
    
                    // Déplacer le fichier dans le répertoire configuré pour les images
                    $imageFile->move(
                        $this->getParameter('images_directory'),  // Assurez-vous que ce paramètre est configuré dans `services.yaml`
                        $newFilename
                    );

    
                    $test->setCreateAd(new \DateTime());
                    // Met à jour la propriété `imagePath` de l'entité Actuc
                    $test->setImagePath($newFilename);
                }
    
                // Sauvegarde de l'entité dans la base de données
                $entityManager->persist($test);
                $entityManager->flush();
    
                $this->addFlash('success', 'Jeu ajouté avec succès!');
                return $this->redirectToRoute('app_test');
            }
        return $this->render('test/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
#[Route('/test/{id}/edit', name: 'test_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'entité Actuc par son ID
        $actuc = $entityManager->getRepository(Test::class)->find($id);
    
        if (!$actuc) {
            throw $this->createNotFoundException('Le test avec l\'ID ' . $id . ' n\'existe pas.');
        }
    
        $form = $this->createForm(TestType::class, $actuc);
        $form->handleRequest($request);
    
        // Traitement du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion des fichiers, sauvegarde, redirection...
        }
            // Création du formulaire pour l'édition de l'entité
    $form = $this->createForm(TestType::class, $actuc);
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
return $this->redirectToRoute('app_listetest');
    }

        return $this->render('test/edit.html.twig', [
            'form' => $form->createView(),
            'test' => $actuc,
        ]);
    }

    #[Route('/test/{id}/delete', name: 'test_delete', methods: ['POST'])]
    public function delete(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        // Utilisation de EntityManagerInterface pour récupérer l'entité Actuc
        $actuc = $entityManager->getRepository(Test::class)->find($id);

        if (!$actuc) {
            throw $this->createNotFoundException('Le bonplan avec l\'ID ' . $id . ' n\'existe pas.');
        }

        // CSRF validation
        if ($this->isCsrfTokenValid('delete' . $actuc->getId(), $request->request->get('_token'))) {
            $entityManager->remove($actuc);
            $entityManager->flush();
            $this->addFlash('success', 'test supprimé avec succès!');
        }

        return $this->redirectToRoute('app_listetest');
    }
}


