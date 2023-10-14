<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddEventController extends AbstractController
{
    #[Route('/add/event', name: 'app_add_event')]
    public function index(): Response
    {
        return $this->render('add_event/index.html.twig', [
            'controller_name' => 'AddEventController',
        ]);
    }
}
