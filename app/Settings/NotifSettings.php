<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class NotifSettings extends Settings
{
    public bool $isEnableDiscordMessage = false;

    public bool $isEnableTelegramMessage = false;

    public bool $isEnableEmailMessage = false;

    public string $discordWebhookUrl;

    public string $telegramBotToken;

    public string $telegramChatId;

    public string $emailTo;

    public static function group(): string
    {
        return 'notif';
    }

    /**
     * @return array<string>
     */
    public static function encrypted(): array
    {
        return [
            'discordWebhookUrl',
            'telegramBotToken',
            'telegramChatId',
            'emailTo',
        ];
    }
}
