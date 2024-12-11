<?php

namespace App\Controller;

use App\Entity\Bonplan;
use App\Form\BonplanType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class BonplanController extends AbstractController
{
    #[Route('/bonplan1', name: 'app_bonplan')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        {
            $bonplan = new Bonplan();
            $form = $this->createForm(BonplanType::class, $bonplan);
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

    
                    $bonplan->setCreateAd(new \DateTime());
                    // Met à jour la propriété `imagePath` de l'entité Actuc
                    $bonplan->setImagePath($newFilename);
                }
    
                // Sauvegarde de l'entité dans la base de données
                $entityManager->persist($bonplan);
                $entityManager->flush();
    
                $this->addFlash('success', 'Jeu ajouté avec succès!');
                return $this->redirectToRoute('app_bonplan');
            }
        return $this->render('bonplan/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
}