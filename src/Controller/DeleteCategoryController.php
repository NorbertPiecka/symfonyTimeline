<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class DeleteCategoryController extends AbstractController
{
    private $appKernel;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, KernelInterface $appKernel)
    {
        $this->entityManager = $entityManager;
        $this->appKernel = $appKernel;
    }
    #[Route('/admin/delete/category/{item}', name: 'app_delete_category')]
    public function index($item): Response
    {
        $category = $this->entityManager->getRepository(Category::class)->find($item);
        $events = $this->entityManager->getRepository(Event::class)->findBy(['category' => $category]);
        if(isset($_POST["submit"]))
        {
            foreach($events as $event) {
                $current_image = $this->appKernel->getProjectDir() . '/public/images//' . $event->getImagePath();
                if (is_file($current_image)) {
                    unlink($current_image);
                }
                $this->entityManager->remove($event);
                $this->entityManager->flush();
            }
            $this->entityManager->remove($category);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_admin_panel');
        }
        return $this->render('delete_category/index.html.twig', [
            'category' => $category,
        ]);
    }
}
