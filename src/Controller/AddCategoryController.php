<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddCategoryController extends AbstractController
{
    #[Route('/add/category', name: 'app_add_category')]
    public function index(): Response
    {
        return $this->render('add_category/index.html.twig', [
            'controller_name' => 'AddCategoryController',
        ]);
    }
}
