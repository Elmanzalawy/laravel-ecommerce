<?php

namespace App\Filament\Pages;

use App\Settings\StoreSettings;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageStore extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string $settings = StoreSettings::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('store_languages')
                    ->options([
                        'en' => 'English',
                        'ar' => 'Arabic',
                    ])
                    ->multiple()
                    ->label(__('Store Languages'))
                    ->required(),
            ]);
    }
}
