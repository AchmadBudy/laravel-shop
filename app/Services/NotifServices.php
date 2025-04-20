<?php

namespace App\Services;

class NotifServices
{

    private bool $isEnableDiscordMessage = false;
    private bool $isEnableTelegramMessage = false;
    private bool $isEnableEmailMessage = false;

    private string $discordWebhookUrl;
    private string $telegramBotToken;
    private string $telegramChatId;
    private string $emailTo;

    /**
     * Create a new class instance.
     */
    public function __construct(
        private string $messages
    )
    {
        //
    }

    public function sendDiscordMessage(string $messages)
    {
        // todo
    }

    public function sendEmailMessage(string $messages)
    {
        // todo
    }

    public function sendTelegramMessage(string $messages)
    {
       try {
        //code...
       } catch (\Throwable $th) {
        //throw $th;
       }
    }
}
