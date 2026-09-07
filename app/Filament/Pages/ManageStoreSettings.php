<?php

namespace App\Filament\Pages;

use App\Settings\StoreSettings;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageStoreSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string $settings = StoreSettings::class;

    protected static ?string $slug = 'store-settings';

    public static function getNavigationGroup(): ?string
    {
        return __(NAVGROUP_SETTINGS);
    }

    public static function getNavigationLabel(): string
    {
        return __('Store Settings');
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            // ->columns(1)
            ->components([
                Section::make(__('Languages Settings'))
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        Select::make('store_languages')
                            ->label(__('Store Languages'))
                            ->multiple()
                            ->options([
                                'en' => __('English'),
                                'ar' => __('Arabic'),
                            ])
                            ->required(),
                    ]),
                Section::make(__('Currency Settings'))
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        TextInput::make('store_currency')
                            ->label(__('Store Currency'))
                            ->required(),
                        TextInput::make('store_currency_symbol')
                            ->label(__('Store Currency Symbol'))
                            ->required(),
                    ]),
            ]);
    }
}
