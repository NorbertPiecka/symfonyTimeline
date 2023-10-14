<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModifyEventController extends AbstractController
{
    #[Route('/modify/event', name: 'app_modify_event')]
    public function index(): Response
    {
        return $this->render('modify_event/index.html.twig', [
            'controller_name' => 'ModifyEventController',
        ]);
    }
}
