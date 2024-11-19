<?php
namespace App\Controller;

use App\Entity\Appointement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppointementController extends AbstractController
{
    #[Route('/appointement', name: 'app_appointement')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $subject = $request->request->get('subject');
            $date = $request->request->get('date');
            $phone = $request->request->get('phone');
            $message = $request->request->get('message');
    
            // Valider les données
            if (empty($name) || empty($email) || empty($subject) || empty($date) || empty($phone) || empty($message)) {
                $this->addFlash('error', 'Tous les champs sont obligatoires.');
                return $this->redirectToRoute('app_appointement');
            }
    
            // Convertir la date en objet \DateTime
            try {
                $dateObject = new \DateTime($date);
            } catch (\Exception $e) {
                $this->addFlash('error', 'La date fournie est invalide.');
                return $this->redirectToRoute('app_appointement');
            }
    
            // Créer l'objet Appointement et assigner les données
            $appointement = new Appointement();
            $appointement->setName($name);
            $appointement->setEmail($email);
            $appointement->setSubject($subject);
            $appointement->setDate($dateObject);
            $appointement->setPhone($phone);  
             $appointement->setMessage($message);
            $appointement->setCreateAd(new \DateTime());
    
            // Sauvegarder l'entité
            try {
                $entityManager->persist($appointement);
                $entityManager->flush();
    
                $this->addFlash('success', 'Votre message a été envoyé avec succès.');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de l\'enregistrement.');
            }
    
            return $this->redirectToRoute('app_appointement');
        }
    
        return $this->render('appointement/index.html.twig');
    }
}    