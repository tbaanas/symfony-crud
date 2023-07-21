<?php

namespace App\Listener;

use App\Service\LoginHistoryService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class LoginEventListener implements EventSubscriberInterface
{
    private RequestStack $requestStack;
    private LoginHistoryService $loginHistoryService;
    private RouterInterface $router;


    public function __construct(RequestStack $requestStack, LoginHistoryService $loginHistoryService, RouterInterface $router)
    {
        $this->requestStack = $requestStack;
        $this->loginHistoryService = $loginHistoryService;
        $this->router = $router;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onInteractiveLogin',
        ];
    }

    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        $request = $event->getRequest();

        $session = $request->getSession();
        // Znajdź użytkownika w bazie danych na podstawie podanego nazwy użytkownika
        // Sprawdź, czy użytkownik jest zbanowany
        if ($this->loginHistoryService->accessDeniedBannedUser($event)) {
            $session->getFlashBag()->add('error', 'Twoje konto jest zablokowane.');

            return new RedirectResponse($this->router->generate('app_login'));
        }

        // TODO dodać triggera po np. 50k usuwa lub jeśli starsze niż 30 dni

        // pobranie danych o sesji
        $this->loginHistoryService->saveLoginHistory($event, $request);
    }
}
