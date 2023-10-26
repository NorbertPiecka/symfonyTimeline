<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ChangePasswordController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/change/password', name: 'app_change_password')]
    public function index(UserPasswordHasherInterface $passwordHasher): Response
    {
        if(isset($_POST["submit"]))
        {
            $validation_ok = true;
            $new_password = $_POST["new_password"];
            $new_password_confirm = $_POST["new_password_confirm"];

            if(strlen($new_password) < 5)
            {
                echo "<script>alert('Password too short');</script>";
                $validation_ok = false;
            }

            if($new_password != $new_password_confirm)
            {
                echo "<script>alert('Passwords are different');</script>";
                $validation_ok = false;
            }

            if($validation_ok)
            {
                $user = $this->entityManager->getRepository(User::class)->findBy(['username'=> 'admin'])[0];
                $hashed_password = $passwordHasher->hashPassword($user, $new_password);
                $user->setPassword($hashed_password);
                $this->entityManager->flush();
                echo "<script>alert('Password changed!');</script>";
                return $this->redirectToRoute('app_admin_panel');
            }
        }
        return $this->render('change_password/index.html.twig', [
        ]);
    }
}
