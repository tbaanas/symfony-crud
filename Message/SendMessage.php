<?php

namespace App\Message;

class SendMessage
{
    public function __construct(private string $title, private string $message){

    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }



}
