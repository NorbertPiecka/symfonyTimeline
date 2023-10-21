<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModifyCategoryController extends AbstractController
{
    #[Route('/modify/category', name: 'app_modify_category')]
    public function index(): Response
    {
        return $this->render('modify_category/index.html.twig', [
            'controller_name' => 'ModifyCategoryController',
        ]);
    }
}
