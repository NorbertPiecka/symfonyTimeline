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

        if(!$category)
        {
            return $this->render('error_page/404_not_found.html.twig');
        }

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

            if(!ctype_xdigit($color) || strlen($color) > 50)
            {
                echo "<script>alert('Wrong value for color');</script>";
                $validation_ok = false;
            }

            if($validation_ok)
            {
                $category->setName($name);
                $category->setColor('#' . $color);
                $this->entityManager->flush();
                echo "<script>alert('Category added!');</script>";
                return $this->redirectToRoute('app_admin_panel');
            }
        }

        return $this->render('modify_category/index.html.twig', [
            'category' => $category,
        ]);
    }
}
