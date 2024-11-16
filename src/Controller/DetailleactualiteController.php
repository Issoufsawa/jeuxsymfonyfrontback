<?php

namespace App\Controller;

use App\Entity\Actualiteimage;
use App\Repository\ActualiteimageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailleactualiteController extends AbstractController
{
    #[Route('/detailleactualite/{id}', name: 'app_detailleactualite')]
    public function detailleactualite( int $id, ActualiteimageRepository $actualiteimageRepository): Response
    {

        $detailleactualite = $actualiteimageRepository->find($id);
       

        if (!$detailleactualite) {
            throw $this->createNotFoundException('Jeu non trouvé');
        }
        $jeux = $actualiteimageRepository->findAll(); // Cette méthode récupère tous les jeux de la table
        return $this->render('detailleactualite/index.html.twig', [
            'controller_name' => 'DetailleactualiteController',
            'detailleactualite' => $detailleactualite,
            'jeux' => $jeux, // Passe la liste des jeux à la vue
        ]);
    }
}
