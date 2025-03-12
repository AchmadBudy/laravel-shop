<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SinglePageSettings extends Settings
{
    public string $garansi_page;

    public string $contact_us_page;
    public static function group(): string
    {
        return 'singlePage';
    }
}
