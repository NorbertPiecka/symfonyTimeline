<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddCategoryController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/admin/add/category', name: 'app_add_category')]
    public function index(): Response
    {
        if(isset($_POST["submit"]))
        {
            $validation_ok = true;
            $name = $_POST["category_name"];
            $color = $_POST["category_color"];

            if(!$name || strlen($name) > 50)
            {
                echo "<script>alert('No name provided or name too long');</script>";
                $validation_ok = false;
            }

            if(!ctype_xdigit($color))
            {
                echo "<script>alert('Color not in hex');</script>";
                $validation_ok = false;
            }

            if($validation_ok)
            {
                $category = new Category();
                $category->setName($name);
                $category->setColor('#' . $color);

                $this->entityManager->persist($category);
                $this->entityManager->flush();
                return $this->redirectToRoute('app_admin_panel');
            }
        }

        return $this->render('add_category/index.html.twig', [
        ]);
    }
}
