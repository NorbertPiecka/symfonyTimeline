<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPanelController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/admin/panel', name: 'app_admin_panel')]
    public function index(): Response
    {
        $events = $this->entityManager->getRepository(Event::class)->findAll();
        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        return $this->render('admin_panel/index.html.twig', [
            'events' => $events, 'categories' => $categories,
        ]);
    }
}
