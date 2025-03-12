<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('singlePage.garansi_page', 'Still work in progress');
        $this->migrator->add('singlePage.contact_us_page', 'Still work in progress');
    }
};
