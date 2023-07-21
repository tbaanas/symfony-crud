<?php

namespace App\Service;

use App\Entity\LoginHistory;
use App\Model\admin\AdminUsersService;
use App\Repository\LoginHistoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginHistoryService
{
    //    private LoginHistoryRepository $repository;
    // private AdminUsersService $aus;

    public function __construct(public LoginHistoryRepository $repository, public AdminUsersService $aus)
    {
        //   $this->repository = $repository;
        // $this->aus=$aus;
    }

    public function viewHistory(): array
    {
        return $this->repository->findAll();
    }

    public function saveLoginHistory(InteractiveLoginEvent $event, Request $request)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $userId = $user->getId();
        $userAgent = $request->headers->get('User-Agent');
        $ipAddress = $request->getClientIp();
        $language = $request->getLocale();
        $log = new LoginHistory();
        $log->setUser($this->aus->findOneById($userId));
        $log->setUserAgent($userAgent);
        $log->setIp($ipAddress);
        $log->setDate(new \DateTime());
        $log->setLanguage($language);
        $this->repository->save($log, true);
    }

    public function accessDeniedBannedUser(InteractiveLoginEvent $event): ?bool
    {
        // Pobierz dane logowania z żądania
        $temp = $event->getAuthenticationToken()->getUser();
        $user = $this->aus->findOneById($temp->getId());

        return $user->isBanned();
    }
}
