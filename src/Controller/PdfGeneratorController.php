<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class PdfGeneratorController extends AbstractController
{
    private $appKernel;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, KernelInterface $appKernel)
    {
        $this->entityManager = $entityManager;
        $this->appKernel = $appKernel;
    }
    #[Route('/pdf/generator', name: 'app_pdf_generator')]
    public function index(): Response
    {
        $events = $this->entityManager->getRepository(Event::class)->findAll();

        return $this->render('pdf_generator/index.html.twig', [
            'events' => $events,
        ]);
    }
}
