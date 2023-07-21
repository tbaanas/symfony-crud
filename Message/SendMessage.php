<?php

namespace App\Message;

class SendMessage
{
    public function __construct(private string $title, private string $message)
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
