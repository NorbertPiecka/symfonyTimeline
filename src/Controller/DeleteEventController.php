<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class DeleteEventController extends AbstractController
{
    private $appKernel;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, KernelInterface $appKernel)
    {
        $this->entityManager = $entityManager;
        $this->appKernel = $appKernel;
    }
    #[Route('/admin/delete/event/{item}', name: 'app_delete_event')]
    public function index($item): Response
    {
        $event = $this->entityManager->getRepository(Event::class)->find($item);

        if(isset($_POST["submit"]))
        {
            $current_image = $this->appKernel->getProjectDir() . '/public/images//'. $event->getImagePath();
            if(is_file($current_image))
            {
                unlink($current_image);
            }
            $this->entityManager->remove($event);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_admin_panel');
        }
        return $this->render('delete_event/index.html.twig', [
            'event' => $event,
        ]);
    }
}
