<?php

namespace App\Controller;

use App\Form\ActualitevideoType;
use App\Entity\Actualitevideo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

class ActualitevideoController extends AbstractController
{
    #[Route('/actualitevideo', name: 'app_actualitevideo')]
    public function index(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        // Création d'un nouvel objet Actualitevideo
        $actualitevideo = new Actualitevideo();

        // Création du formulaire associé à l'entité
        $form = $this->createForm(ActualitevideoType::class, $actualitevideo);
        $form->handleRequest($request);

        // Vérification de la soumission et de la validité du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le fichier vidéo
            $videoFile = $form->get('videoFile')->getData();

            if ($videoFile) {
                // Générer un nom unique pour le fichier
                $originalFilename = pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename); // Utiliser slugger ici
                $newFilename = $safeFilename.'-'.uniqid().'.'.$videoFile->guessExtension();

                // Déplacer le fichier dans le dossier de destination
                $videoFile->move(
                    $this->getParameter('videos_directory'), // Chemin configuré dans services.yaml
                    $newFilename
                );

                // Définir le chemin du fichier vidéo dans l'entité
                $actualitevideo->setVideoPath($newFilename);

                // Définir la date de création (create_ad) à la date actuelle
                 $actualitevideo->setCreateAd(new \DateTime());

                // Sauvegarder l'entité dans la base de données
                $em->persist($actualitevideo);
                $em->flush();

                // Ajouter un message flash et rediriger
                $this->addFlash('success', 'Vidéo uploadée avec succès!');
                return $this->redirectToRoute('app_actualitevideo'); // Redirige vers la liste des vidéos
            }
        }

        // Rendu du formulaire dans le template
        return $this->render('actualitevideo/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    #[Route('/listeactualitevideo', name: 'app_listeactualitevideo')]
    public function listeactualitevideo(ManagerRegistry $mr) : Response
    {
      $allactualitevideo = $mr->getRepository(Actualitevideo::class)->findAll();

       return $this->render('listeactualitevideo/listeactualitevideo.html.twig',['allactualitevideo' => $allactualitevideo]);
    }
}
