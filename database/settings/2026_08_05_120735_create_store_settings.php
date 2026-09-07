<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('store.store_languages', ['en', 'ar']);
        $this->migrator->add('store.store_currency', 'EGP');
        $this->migrator->add('store.store_currency_symbol', 'E£');
    }
};
