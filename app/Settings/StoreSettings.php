<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class StoreSettings extends Settings
{
    public array $store_languages;

    public static function group(): string
    {
        return 'store';
    }
}
