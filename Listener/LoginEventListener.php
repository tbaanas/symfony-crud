<?php

namespace App\Listener;

use App\Entity\LoginHistory;
use App\Entity\User;
use App\Model\admin\AdminUsersService;
use App\Repository\LoginHistoryRepository;
use App\Service\LoginHistoryService;
use DateTime;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\HttpFoundation\RequestStack;

class LoginEventListener implements EventSubscriberInterface
{
    private RequestStack $requestStack;
    private LoginHistoryService $loginHistoryService;


    public function __construct(RequestStack $requestStack,LoginHistoryService $loginHistoryService)
    {
        $this->requestStack = $requestStack;
        $this->loginHistoryService=$loginHistoryService;

    }

    #[ArrayShape([SecurityEvents::INTERACTIVE_LOGIN => "string"])] public static function getSubscribedEvents(): array
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onInteractiveLogin',
        ];
    }

    public function onInteractiveLogin(InteractiveLoginEvent $event,Request $request,RouterInterface $router)
    {



        $session = $request->getSession();
        // Znajdź użytkownika w bazie danych na podstawie podanego nazwy użytkownika
        // Sprawdź, czy użytkownik jest zbanowany
        if ($this->loginHistoryService->accessDeniedBannedUser($event)) {
            $session->getFlashBag()->add('error', 'Twoje konto jest zablokowane.');
            return new RedirectResponse($router->generate('app_login'));
        }

        // Sprawdź, czy użytkownik istnieje i czy jest zbanowany
     //   if ($this->loginHistoryService->accessDeniedBannedUser($event)) {
        //    dd($this->loginHistoryService->accessDeniedBannedUser($event));
       //     throw new NotFoundHttpException('Użytkownik nie istnieje lub jest zbanowany.',null,405);
       // }




        //TODO dodać triggera po np. 50k usuwa lub jeśli starsze niż 30 dni

        // pobranie danych o sesji
        $request2 = $this->requestStack->getCurrentRequest();
        $this->loginHistoryService->saveLoginHistory($event,$request2);


    }


}