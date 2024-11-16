<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListeactuvideoController extends AbstractController
{
    #[Route('/listeactuvideo', name: 'app_listeactuvideo')]
    public function index(): Response
    {
        return $this->render('listeactuvideo/index.html.twig', [
            'controller_name' => 'ListeactuvideoController',
        ]);
    }
}
