<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NotifyService
{
    public function sendDiscordMessage($message)
    {
        try {
            $url = env('DISCORD_WEBHOOK_URL');
            $data = ['content' => $message];
            $response = Http::post($url, $data);

            if ($response->failed()) {
                throw new \Exception('Failed to send message to Discord');
            }

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }


    public function sendTelegramMessage($message)
    {
        try {
            $url = 'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage';
            $data = [
                'chat_id' => env('TELEGRAM_CHAT_ID'),
                'text' => $message,
            ];
            $response = Http::post($url, $data);

            if ($response->failed()) {
                throw new \Exception('Failed to send message to Telegram');
            }

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }


    public function sendAll($message)
    {
        if ('discordtrue') {
            $discord = $this->sendDiscordMessage($message);
        }

        if ('telegramtrue') {
            $telegram = $this->sendTelegramMessage($message);
        }
    }
}
