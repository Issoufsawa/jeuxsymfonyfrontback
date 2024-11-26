<?php

namespace App\Controller;

use App\Entity\Actuc;
use App\Entity\Actualiteimage;
use App\Repository\ActucRepository;
use App\Repository\ActualiteimageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailleController extends AbstractController
{
    #[Route('/detaille/{id}', name: 'app_detaille')]
    public function detaille(int $id, ActucRepository $actucRepository , ActualiteimageRepository $actualiteimageRepository ): Response
    {

        // dump($id);
        $detaille1 = $actucRepository->find($id);
        // $detaille1 = $this->getDoctrine()->getRepository(Actuc::class)->find($id);
 
    //   dd($detaille1);


        if (!$detaille1) {
            throw $this->createNotFoundException('Jeu non trouvé');
        }
        // dd($detaille1);
        $jeux = $actualiteimageRepository->findLastThree(); // Cette méthode récupère tous les jeux de la table
        return $this->render('detaille/index.html.twig', [
            'controller_name' => 'DetailleController',
            'detaille1' => $detaille1,
            'jeux' => $jeux, // Passe la liste des jeux à la vue
        ]);
    }


    
}
