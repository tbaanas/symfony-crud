<?php

namespace App\OpenAI;

class Url
{
    public const ORIGIN = 'https://api.openai.com';
    public const API_VERSION = 'v1';
    public const OPEN_AI_URL = self::ORIGIN.'/'.self::API_VERSION;

    /**
     * @deprecated
     */
    public static function completionURL(string $engine): string
    {
        return self::OPEN_AI_URL."/engines/$engine/completions";
    }

    public static function completionsURL(): string
    {
        return self::OPEN_AI_URL.'/completions';
    }

    public static function editsUrl(): string
    {
        return self::OPEN_AI_URL.'/edits';
    }

    public static function searchURL(string $engine): string
    {
        return self::OPEN_AI_URL."/engines/$engine/search";
    }

    public static function enginesUrl(): string
    {
        return self::OPEN_AI_URL.'/engines';
    }

    public static function engineUrl(string $engine): string
    {
        return self::OPEN_AI_URL."/engines/$engine";
    }

    public static function classificationsUrl(): string
    {
        return self::OPEN_AI_URL.'/classifications';
    }

    public static function moderationUrl(): string
    {
        return self::OPEN_AI_URL.'/moderations';
    }

    public static function transcriptionsUrl(): string
    {
        return self::OPEN_AI_URL.'/audio/transcriptions';
    }

    public static function translationsUrl(): string
    {
        return self::OPEN_AI_URL.'/audio/translations';
    }

    public static function filesUrl(): string
    {
        return self::OPEN_AI_URL.'/files';
    }

    public static function fineTuneUrl(): string
    {
        return self::OPEN_AI_URL.'/fine-tunes';
    }

    public static function fineTuneModel(): string
    {
        return self::OPEN_AI_URL.'/models';
    }

    public static function answersUrl(): string
    {
        return self::OPEN_AI_URL.'/answers';
    }

    public static function imageUrl(): string
    {
        return self::OPEN_AI_URL.'/images';
    }

    public static function embeddings(): string
    {
        return self::OPEN_AI_URL.'/embeddings';
    }

    public static function chatUrl(): string
    {
        return self::OPEN_AI_URL.'/chat/completions';
    }
}
