<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_home_page')]
    public function index(): Response
    {
        $events = $this->entityManager->getRepository(Event::class)->findAll();
        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        return $this->render('home_page/index.html.twig', [
            'events' => $events, 'categories' => $categories,
        ]);
    }

    #[Route('/{item}', name: 'app_home_page_id')]
    public function getOnlyOneCategory($item): Response
    {
        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        $category = $this->entityManager->getRepository(Category::class)->find($item);
        $events = $this->entityManager->getRepository(Event::class)->findBy(['category' => $category]);
        return $this->render('home_page/index.html.twig', [
            'events' => $events, 'categories' => $categories,
        ]);
    }
}
