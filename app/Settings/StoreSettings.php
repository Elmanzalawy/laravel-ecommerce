<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class StoreSettings extends Settings
{
    public array $store_languages;
    public string $store_currency;
    public string $store_currency_symbol;

    public static function group(): string
    {
        return 'store';
    }
}
