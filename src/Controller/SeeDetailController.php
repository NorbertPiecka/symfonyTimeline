<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class SeeDetailController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/see/detail/{item}', name: 'app_see_detail')]
    public function index($item): Response
    {
        $event = $this->entityManager->getRepository(Event::class)->find($item);
        return $this->render('see_detail/index.html.twig', [
            'event' => $event,
        ]);
    }
}
