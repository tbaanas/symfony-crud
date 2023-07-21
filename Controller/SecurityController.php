<?php

namespace App\Controller;

use App\Entity\User;
use App\Model\admin\AdminUsersService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private AdminUsersService $userService;

    public function __construct(AdminUsersService $userService)
    {
        $this->userService = $userService;
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(Request $request, AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager): Response
    {
        // Pobierz ostatni udany login użytkownika (jeśli istnieje)
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($this->getUser()) {
            return $this->redirectToRoute('app_admin');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
