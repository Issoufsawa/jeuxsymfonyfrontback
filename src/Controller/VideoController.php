<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;


class VideoController extends AbstractController
{
    #[Route('/video1', name: 'app_video1')]
    public function index(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {

        
            $video = new Video();
            $form = $this->createForm(VideoType::class, $video);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                // Récupérer le fichier vidéo
                $videoFile = $form->get('videoFile')->getData();
    
                if ($videoFile) {
                    // Générer un nom unique pour le fichier
                    $originalFilename = pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$videoFile->guessExtension();
    
                    // Déplacer le fichier dans le dossier de destination
                    $videoFile->move(
                        $this->getParameter('videos_directory'), // Chemin configuré dans services.yaml
                        $newFilename
                    );
    
                    // Définir le chemin dans l'entité Video
                    $video->setVideoPath($newFilename);

                    
                    $video->setCreateAd(new \DateTime());
    
                    // Sauvegarder dans la base de données
                    $em->persist($video);
                    $em->flush();
    
                    $this->addFlash('success', 'Vidéo uploadée avec succès!');
                    return $this->redirectToRoute('app_video'); // Redirige vers la liste des vidéos
                }
            }


        return $this->render('video/index.html.twig', [
            'form' => $form->createView(), // Assurez-vous que 'form' est transmis ici
        ]);
    }

    #[Route('/videoliste', name: 'app_videoliste')]
    public function videoliste(ManagerRegistry $mr) : Response
    {
      $allvideo = $mr->getRepository(Video::class)->findAll();

       return $this->render('videoliste/videoliste.html.twig',['allvideo' => $allvideo]);
    }

  
    

    #[Route('/video/{id}/delete', name: 'video_delete', methods: ['POST'])]
    public function delete(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        // Utilisation de EntityManagerInterface pour récupérer l'entité Actuc
        $actuc = $entityManager->getRepository(Video::class)->find($id);

        if (!$actuc) {
            throw $this->createNotFoundException('Le video avec l\'ID ' . $id . ' n\'existe pas.');
        }

        // CSRF validation
        if ($this->isCsrfTokenValid('delete' . $actuc->getId(), $request->request->get('_token'))) {
            $entityManager->remove($actuc);
            $entityManager->flush();
            $this->addFlash('success', 'video supprimé avec succès!');
        }

        return $this->redirectToRoute('app_videoliste');
    }
}
