<?php

namespace App\Controller;

use App\Repository\ActucRepository;
use App\Entity\Actuc;
use App\Entity\Actualiteimage;
use App\Form\ActualiteimageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class ActualiteController extends AbstractController

{

    /**
     * @Route("/detaille/{id}", name="app_detaille")
     */ 
    #[Route('/actualite', name: 'app_actualite')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
    
    $actualiteimage = new Actualiteimage();
    $form = $this->createForm(ActualiteimageType::class, $actualiteimage);
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

            // Définir la date de création (create_ad) à la date actuelle
            $actualiteimage->setCreateAd(new \DateTime());

            // Met à jour la propriété `imagePath` de l'entité Actuc
            $actualiteimage->setImagePath($newFilename);
        }

        // Sauvegarde de l'entité dans la base de données
        $entityManager->persist($actualiteimage);
        $entityManager->flush();

        $this->addFlash('success', 'Jeu ajouté avec succès!');
        return $this->redirectToRoute('app_actualite');
    }

    return $this->render('actualite/index.html.twig', [
        'form' => $form->createView(),
    ]);
}

#[Route('/listeactualiteimage ', name: 'app_listeactualiteimage')]
public function listeactualitevideo(ManagerRegistry $mr , Request $request) : Response
{
    // Nombre d'éléments par page
    $limit = 3;

    // Numéro de la page (par défaut 1)
    $page = max(1, $request->query->getInt('page', 1));

    // Calculer l'offset
    $offset = ($page - 1) * $limit;

    // Récupérer le repository
    $repository = $mr->getRepository(Actualiteimage::class);

    // Récupérer le total des entrées
    $total = $repository->count([]);

    // Récupérer les entrées paginées
    $allactualiteimage = $repository->findBy([], null, $limit, $offset);

    // Calculer le nombre total de pages
    $totalPages = ceil($total / $limit);

    // Renvoyer les données à la vue
    return $this->render('listeactualiteimage/listeactualiteimage.html.twig', [
        'allactualiteimage' => $allactualiteimage,
        'currentPage' => $page,
        'totalPages' => $totalPages,
    ]);
}

#[Route('/actualite/{id}/edit', name: 'actualite_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, $id, EntityManagerInterface $entityManager): Response
{
    // Récupérer l'entité Actuc par son ID
    $actuc = $entityManager->getRepository(Actualiteimage::class)->find($id);

    if (!$actuc) {
        throw $this->createNotFoundException('Le jeu avec l\'ID ' . $id . ' n\'existe pas.');
    }

    $form = $this->createForm(ActualiteimageType::class, $actuc);
    $form->handleRequest($request);

    // Traitement du formulaire
    if ($form->isSubmitted() && $form->isValid()) {
        // Gestion des fichiers, sauvegarde, redirection...
    }
        // Création du formulaire pour l'édition de l'entité
$form = $this->createForm(ActualiteimageType::class, $actuc);
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
    $this->addFlash('success', 'actualite modifié avec succès!'); 
// Redirection vers la liste des jeux    
return $this->redirectToRoute('app_listeactualiteimage');
}
    return $this->render('actualite/edit.html.twig', [
        'form' => $form->createView(),
        'actualiteimage' => $actuc,
    ]);
}

#[Route('/actualite/{id}/delete', name: 'actualite_delete', methods: ['POST'])]
public function delete(Request $request, $id, EntityManagerInterface $entityManager): Response
{
    // Utilisation de EntityManagerInterface pour récupérer l'entité Actuc
    $actuc = $entityManager->getRepository(Actualiteimage::class)->find($id);

    if (!$actuc) {
        throw $this->createNotFoundException('actualite avec l\'ID ' . $id . ' n\'existe pas.');
    }

    // CSRF validation
    if ($this->isCsrfTokenValid('delete' . $actuc->getId(), $request->request->get('_token'))) {
        $entityManager->remove($actuc);
        $entityManager->flush();
        $this->addFlash('success', 'actualite supprimé avec succès!');
    }

    return $this->redirectToRoute('app_listeactualiteimage');
}
}
