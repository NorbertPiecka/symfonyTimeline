<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RemoveEventController extends AbstractController
{
    #[Route('/remove/event', name: 'app_remove_event')]
    public function index(): Response
    {
        return $this->render('remove_event/index.html.twig', [
            'controller_name' => 'RemoveEventController',
        ]);
    }
}
