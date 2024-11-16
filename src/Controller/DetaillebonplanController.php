<?php

namespace App\Controller;

use App\Entity\Bonplan;
use App\Entity\Actualiteimage;
use App\Repository\BonplanRepository;
use App\Repository\ActualiteimageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetaillebonplanController extends AbstractController
{
    #[Route('/detaillebonplan/{id}', name: 'app_detaillebonplan')]
    public function detaillebonplan(int $id,BonplanRepository $bonplanRepository , ActualiteimageRepository $actualiteimageRepository ): Response
    {
        $detaillebonplan = $bonplanRepository->find($id);
        // $detaille1 = $this->getDoctrine()->getRepository(Actuc::class)->find($id);

        if (!$detaillebonplan) {
            throw $this->createNotFoundException('Jeu non trouvé');
        }
        // dd($detaille1);
        $jeux = $actualiteimageRepository->findLastThree(); // Cette méthode récupère tous les jeux de la table
        return $this->render('detaillebonplan/index.html.twig', [
            'controller_name' => 'DetaillebonplanController',
            'detaillebonplan' => $detaillebonplan,
            'jeux' => $jeux, // Passe la liste des jeux à la vue
        ]);
    }
}
