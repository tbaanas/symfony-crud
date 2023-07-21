<?php

namespace App;

use OpenAI\Client;

final class OpenAI
{
    /**
     * Creates a new Open AI Client with the given API token.
     */
    public static function client(string $apiKey, string $organization = null): Client
    {
        return self::factory()
            ->withApiKey($apiKey)
            ->withOrganization($organization)
            ->make();
    }

    /**
     * Creates a new factory instance to configure a custom Open AI Client.
     */
    public static function factory(): Factory
    {
        return new Factory();
    }
}
