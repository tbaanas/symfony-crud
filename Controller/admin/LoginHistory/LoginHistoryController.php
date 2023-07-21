<?php

namespace App\Controller\admin\LoginHistory;

use App\Service\LoginHistoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginHistoryController extends AbstractController
{
    private LoginHistoryService $service;

    public function __construct(LoginHistoryService $service)
    {
        $this->service = $service;
    }

    #[Route('/admin/login-history', name: 'app_login_history', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/login_history/index.html.twig', [
            'histories' => $this->service->viewHistory(),
        ]);
    }
}
