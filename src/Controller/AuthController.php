<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use App\Routing\Attribute\Route;
use App\Services\SessionManager;

class AuthController extends AbstractController
{
    #[Route('/signup', 'signup')]
    public function signup(): string
    {
        return $this->twig->render('auth/signup.html.twig');
    }

    #[Route('/signup/confirm', 'signup_confirm', 'POST')]
    public function addUSer(EntityManager $em): void
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $newUser = new User();
        $newUser
            ->setUsername($username)
            ->setPassword($password);

        $em->persist($newUser);
        $em->flush();

        $this->redirect('/login/confirm');
    }

    #[Route('/login', 'login')]
    public function login(): string
    {
        return $this->twig->render('auth/login.html.twig');
    }

    #[Route('/login/validation', 'login_validation', 'POST')]
    public function auth()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($username === 'utilisateur' && $password === 'motdepasse') {
            $sessionManager = new SessionManager();
            $sessionManager->set('user', $username);
            $this->redirect('/login/confirm');
            exit();
        } else {
            echo "Authentification échouée";
            $this->redirect('/login');
            exit();
        }
    }

    #[Route('/login/confirm', 'login_confirm')]
    public function confirm(): string
    {
        return $this->twig->render('auth/confirm.html.twig');
    }
}
