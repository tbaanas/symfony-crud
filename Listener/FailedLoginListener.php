<?php

namespace App\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;

use Symfony\Component\Security\Http\SecurityEvents;
use Psr\Log\LoggerInterface;

class FailedLoginListener implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
           // SecurityEvents::AUTHENTICATION_FAILURE => 'onAuthenticationFailure',
        ];
    }

    public function onAuthenticationFailure(AuthenticationFailureEvent $event)
    {
// Rejestrowanie błędu logowania
        $authenticationException = $event->getAuthenticationException();
        $username = $event->getAuthenticationToken()->getUsername();
        $this->logger->error('Nieudane logowanie użytkownika: ' . $username, ['exception' => $authenticationException]);
    }
}