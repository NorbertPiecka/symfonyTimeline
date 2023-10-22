<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class AddEventController extends AbstractController
{
    private $appKernel;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, KernelInterface $appKernel)
    {
        $this->entityManager = $entityManager;
        $this->appKernel = $appKernel;
    }
    #[Route('/admin/add/event', name: 'app_add_event')]
    public function index(): Response
    {
        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        if(isset($_POST["submit"]))
        {
            $validation_ok = true;
            $name = $_POST["event_name"];
            $start_date = $_POST["start_date"];
            $end_date = $_POST["end_date"];
            $create_date = date('Y-m-d h:i:s',time());
            $update_date = date('Y-m-d h:i:s',time());
            $desc = $_POST["event_desc"];
            $category = $_POST["event_category"];
            $minimal_date = "1939-09-01";
            $max_date = "1945-09-02";

            if(!$name || strlen($name) > 50)
            {
                echo "<script>alert('No event name provided or event name too long');</script>";
                $validation_ok = false;
            }

            if(!$desc || strlen($desc)>250)
            {
                echo "<script>alert('No description provided or description too long');</script>";
                $validation_ok = false;
            }

            if(!$category)
            {
                echo "<script>alert('No category choose');</script>";
                $validation_ok = false;
            }

            if($start_date < $minimal_date || $start_date > $max_date || !$start_date)
            {
                echo "<script>alert('Wrong start date');</script>";
                $validation_ok = false;
            }

            if($end_date < $minimal_date || $end_date > $max_date || !$end_date)
            {
                echo "<script>alert('');</script>";
                $validation_ok = false;
            }

            if($start_date > $end_date)
            {
                echo "<script>alert('Start date can not be older than end data);</script>";
                $validation_ok = false;
            }

            if($_FILES["images"]["error"] === 4)
            {
                echo "<script>alert('Image dose not exist');</script>";
                $validation_ok = false;
            }
            else
            {
                $file_name = $_FILES["images"]["name"];
                $file_size = $_FILES["images"]["size"];
                $tmp_name = $_FILES["images"]["tmp_name"];
                $valid_extensions = ['jpg', 'jpeg', 'png'];
                $image_extension = explode('.', $file_name);
                $image_extension = strtolower(end($image_extension));
                if(!in_array($image_extension, $valid_extensions))
                {
                    echo "<script>alert('Invalid file extension');</script>";
                    $validation_ok = false;
                }
                else if($file_size > 1000000)
                {
                    echo "<script>alert('Image size too large');</script>";
                    $validation_ok = false;
                }
                else
                {
                    $image_name = uniqid();
                    $image_name .= '.' . $image_extension;
                    $destination = $this->appKernel->getProjectDir() . 'public\images\\'. $image_name;
                    move_uploaded_file($tmp_name, $destination);
                }
            }

            if($validation_ok)
            {
                $event = new Event();
                $event->setName($name);
                $event->setStartDate(new \DateTimeImmutable($start_date));
                $event->setEndDate(new \DateTimeImmutable($end_date));
                $event->setCreateDate(new \DateTimeImmutable($create_date));
                $event->setUpdateDate(new \DateTimeImmutable($update_date));
                $event->setDescription($desc);
                $event->setCategory($this->entityManager->getRepository(Category::class)->find($category));
                $event->setImagePath($image_name);
                $this->entityManager->persist($event);
                $this->entityManager->flush();
                return $this->redirectToRoute('app_admin_panel');
            }
        }

        return $this->render('add_event/index.html.twig',
            ['categories' => $categories,
                ]);
    }
}
