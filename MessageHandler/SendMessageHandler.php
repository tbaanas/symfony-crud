<?php

namespace App\MessageHandler;

use App\Message\SendMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendMessageHandler
{
    public function __invoke(SendMessage $message)
    {
      
    }
}
