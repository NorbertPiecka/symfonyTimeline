<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModifyCategoryController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/admin/modify/category/{item}', name: 'app_modify_category')]
    public function index($item): Response
    {
        $category = $this->entityManager->getRepository(Category::class)->find($item);

        return $this->render('modify_category/index.html.twig', [
            'category' => $category,
        ]);
    }
}
