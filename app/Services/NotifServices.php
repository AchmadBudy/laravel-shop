<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Notif\NotifAllResponseDTO;
use App\DTOs\Notif\NotifChannelResponseDTO;
use App\Mail\NotifMail;
use App\Settings\NotifSettings;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

final readonly class NotifServices
{
    /**
     * NotifServices constructor.
     */
    public function __construct(
        private string $messages,
        private string $subject,
        private NotifSettings $notifSettings
    ) {}

    /**
     * Send all enabled notifications (Discord, Telegram, Email).
     */
    public function sendAllNotification(): NotifAllResponseDTO
    {
        $response = [];
        if ($this->notifSettings->isEnableDiscordMessage) {
            $response[] = $this->sendDiscordMessage($this->messages, $this->subject);
        }
        if ($this->notifSettings->isEnableTelegramMessage) {
            $response[] = $this->sendTelegramMessage($this->messages, $this->subject);
        }
        if ($this->notifSettings->isEnableEmailMessage) {
            $response[] = $this->sendEmailMessage($this->messages, $this->subject);
        }

        return new NotifAllResponseDTO(
            data: $response,
        );
    }

    /**
     * Send Discord Message.
     */
    public function sendDiscordMessage(string $messages, string $subject): NotifChannelResponseDTO
    {
        try {
            // check if discord message is enabled
            if (! $this->notifSettings->isEnableDiscordMessage) {
                throw new \Exception('Discord message is not enabled');
            }

            $url = $this->notifSettings->discordWebhookUrl;
            $data = [
                'content' => "There's a new Notification from your application. IT'S $subject",
                'embeds' => [
                    [
                        'title' => $subject,
                        'description' => $messages,
                        'color' => 16711680,
                    ],
                ],
            ];
            $response = Http::post($url, $data);
            if ($response->failed()) {
                Log::error('Failed to send message to Discord', ['response' => $response->body()]);
                throw new \Exception('Failed to send message to Discord');
            }

            return new NotifChannelResponseDTO(
                success: true,
            );
        } catch (\Throwable $th) {
            Log::error('Error sending Discord message', ['exception' => $th]);

            return new NotifChannelResponseDTO(
                success: false,
                errorMessage: $th->getMessage(),
            );
        }
    }

    /**
     * Send Email Message.
     */
    public function sendEmailMessage(string $messages, string $subject): NotifChannelResponseDTO
    {
        try {
            // check if email message is enabled
            if (! $this->notifSettings->isEnableEmailMessage) {
                throw new \Exception('Email message is not enabled');
            }

            Mail::to($this->notifSettings->emailTo)->send(new NotifMail(
                messages: $messages,
                subjectMail: $subject
            ));

            return new NotifChannelResponseDTO(
                success: true,
            );
        } catch (\Throwable $th) {
            Log::error('Error sending Email message', ['exception' => $th]);

            return new NotifChannelResponseDTO(
                success: false,
                errorMessage: $th->getMessage(),
            );
        }
    }

    /**
     * Send Telegram Message.
     */
    public function sendTelegramMessage(string $messages, string $subject): NotifChannelResponseDTO
    {
        try {
            // check if telegram message is enabled
            if (! $this->notifSettings->isEnableTelegramMessage) {
                throw new \Exception('Telegram message is not enabled');
            }

            $url = 'https://api.telegram.org/bot'.$this->notifSettings->telegramBotToken.'/sendMessage';
            // Escape special characters for MarkdownV2
            $escape = fn ($text) => preg_replace('/([_*\[\]()~`>#+\-=|{}.!])/', '\\\\$1', $text);
            $formattedMessage = '*'.$escape($subject)."*\n\n".$escape($messages);
            $data = [
                'chat_id' => $this->notifSettings->telegramChatId,
                'text' => $formattedMessage,
                'parse_mode' => 'MarkdownV2',
            ];
            $response = Http::post($url, $data);
            if ($response->failed()) {
                Log::error('Failed to send Telegram message', ['response' => $response->body()]);
                throw new \Exception('Failed to send Telegram message');
            }

            return new NotifChannelResponseDTO(
                success: true,
            );
        } catch (\Throwable $th) {
            Log::error('Error sending Telegram message', ['exception' => $th]);

            return new NotifChannelResponseDTO(
                success: false,
                errorMessage: $th->getMessage(),
            );
        }
    }
}
