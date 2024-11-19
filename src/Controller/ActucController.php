<?php

namespace App\Controller;

use App\Entity\Actuc;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ActucController extends  AbstractController
{
    #[Route('/actuc', name: 'app_actuc')]
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {

    $actuc= new Actuc();
    $form=$this->createForm(ActucType::class, $actuc);
    $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
    //         // Sauvegarder le fichier image, gérer l'entité et persister en base de données ici
         $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($actuc);
         $entityManager->flush();

         if (!$actuc->getDate()) {
            $actuc->setDate(new \DateTime()); // Définit la date actuelle par défaut
        }

      }


        return $this->render('actuc/index.html.twig');
    }
}



