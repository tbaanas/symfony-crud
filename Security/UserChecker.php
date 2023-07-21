<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if ($user->isBanned()) {
            throw new CustomUserMessageAuthenticationException('Konto zostało zablokowane, powód: '.$user->getBanReason());
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
    }
}
