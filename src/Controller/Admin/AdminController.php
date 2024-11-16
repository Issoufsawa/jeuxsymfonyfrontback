<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController{

    #[Route('/', name: 'app_jeux1_page')]
    public function admin() : Response
    {
       return $this->render(view:"admin/home.html.twig");
    }

   
}