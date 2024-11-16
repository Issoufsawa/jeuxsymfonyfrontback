<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApercuController extends AbstractController
{
    #[Route('/apercu', name: 'app_apercu')]
    public function index(): Response
    {
        return $this->render('apercu/index.html.twig', [
            'controller_name' => 'ApercuController',
        ]);
    }
}
