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
public function listeactualitevideo(ManagerRegistry $mr) : Response
{
  $allactualiteimage = $mr->getRepository(Actualiteimage::class)->findAll();

   return $this->render('listeactualiteimage/listeactualiteimage.html.twig',['allactualiteimage' => $allactualiteimage]);
}


}