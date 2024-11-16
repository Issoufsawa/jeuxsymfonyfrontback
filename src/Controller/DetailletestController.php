<?php

namespace App\Controller;

use App\Entity\Test;
use App\Entity\Actualiteimage;
use App\Repository\TestRepository;
use App\Repository\ActualiteimageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailletestController extends AbstractController
{
    #[Route('/detailletest/{id}', name: 'app_detailletest')]
    public function detailletest(int $id,TestRepository $testRepository , ActualiteimageRepository $actualiteimageRepository ): Response
    {
        $detailletest = $testRepository->find($id);
        // $detaille1 = $this->getDoctrine()->getRepository(Actuc::class)->find($id);

        if (!$detailletest) {
            throw $this->createNotFoundException('Jeu non trouvé');
        }
        // dd($detaille1);
        $jeux = $actualiteimageRepository->findLastThree(); // Cette méthode récupère tous les jeux de la table
        return $this->render('detailletest/index.html.twig', [
            'controller_name' => 'DetailletestController',
            'detailletest' => $detailletest,
            'jeux' => $jeux, // Passe la liste des jeux à la vue
        ]);
    }
}
