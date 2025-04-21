<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('notif.isEnableDiscordMessage',false);
        $this->migrator->add('notif.isEnableTelegramMessage',false);
        $this->migrator->add('notif.isEnableEmailMessage',false);
        $this->migrator->addEncrypted('notif.emailTo','');
        $this->migrator->addEncrypted('notif.discordWebhookUrl','');
        $this->migrator->addEncrypted('notif.telegramBotToken','');
        $this->migrator->addEncrypted('notif.telegramChatId','');
    }
};
