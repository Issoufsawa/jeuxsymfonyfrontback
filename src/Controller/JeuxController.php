<?php
namespace App\Controller;

use App\Entity\Actuc;
use App\Form\ActucType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry; // Ajoute cette ligne pour les autres injections de services si nécessaire

class JeuxController extends AbstractController
{
    #[Route('/jeux', name: 'app_jeux')]
    public function addGame(Request $request, EntityManagerInterface $entityManager): Response
    {
        $actuc = new Actuc();
        $form = $this->createForm(ActucType::class, $actuc);
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

                // Met à jour la propriété `imagePath` de l'entité Actuc
                $actuc->setImagePath($newFilename);
            }

            // Sauvegarde de l'entité dans la base de données
            $entityManager->persist($actuc);
            $entityManager->flush();

            $this->addFlash('success', 'Jeu ajouté avec succès!');
            return $this->redirectToRoute('app_jeux');
        }

        return $this->render('jeux/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/Jeuxliste', name: 'app_jeuxliste')]
    public function jeuxliste(ManagerRegistry $mr): Response
    {
        // Récupérer toutes les entrées de l'entité Actuc
        $alljeux = $mr->getRepository(Actuc::class)->findAll();
        // Passer la variable alljeux à la vue
        return $this->render('jeuxliste/jeuxliste.html.twig', [
            'alljeux' => $alljeux,  // Assurez-vous que cette variable est passée à Twig
        ]);
    }

    #[Route('/jeux/{id}/edit', name: 'jeu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'entité Actuc par son ID
        $actuc = $entityManager->getRepository(Actuc::class)->find($id);
    
        if (!$actuc) {
            throw $this->createNotFoundException('Le jeu avec l\'ID ' . $id . ' n\'existe pas.');
        }
    
        $form = $this->createForm(ActucType::class, $actuc);
        $form->handleRequest($request);
    
        // Traitement du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion des fichiers, sauvegarde, redirection...
        }
            // Création du formulaire pour l'édition de l'entité
    $form = $this->createForm(ActucType::class, $actuc);
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
        $this->addFlash('success', 'Jeu modifié avec succès!'); 
// Redirection vers la liste des jeux    
return $this->redirectToRoute('app_jeuxliste');
    }
        return $this->render('jeux/edit.html.twig', [
            'form' => $form->createView(),
            'jeu' => $actuc,
        ]);
    }

    #[Route('/jeux/{id}/delete', name: 'jeu_delete', methods: ['POST'])]
    public function delete(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        // Utilisation de EntityManagerInterface pour récupérer l'entité Actuc
        $actuc = $entityManager->getRepository(Actuc::class)->find($id);

        if (!$actuc) {
            throw $this->createNotFoundException('Le jeu avec l\'ID ' . $id . ' n\'existe pas.');
        }

        // CSRF validation
        if ($this->isCsrfTokenValid('delete' . $actuc->getId(), $request->request->get('_token'))) {
            $entityManager->remove($actuc);
            $entityManager->flush();
            $this->addFlash('success', 'Jeu supprimé avec succès!');
        }

        return $this->redirectToRoute('app_jeuxliste');
    }
}
