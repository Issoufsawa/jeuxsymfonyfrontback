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
}
