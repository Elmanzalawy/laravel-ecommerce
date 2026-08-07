<?php

namespace App\Filament\Resources\ProductCategories\Schemas;

use App\Models\ProductCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('parent_id')
                    ->label(__('Parent Category'))
                    ->options(ProductCategory::pluck('name', 'id')),
                static::getTranslationsSection(),
                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated()
                    ->default(fn(Get $get) => Str::slug($get('name.en')))
                    ->unique(ignoreRecord: true)
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function getTranslationsSection(): Component
    {
        $storeLanguages = app(\App\Settings\StoreSettings::class)->store_languages;
        $translationsSection = Section::make(__('Translations'))
            ->collapsible()
            ->collapsed(false)
            ->columns(1)
            ->schema($translationsSchema = []);

        foreach ($storeLanguages as $language) {
            $translationsSchema[] = TextInput::make("name.{$language}")
                ->default(fn(?ProductCategory $record) => $record?->name[$language] ?? null)
                ->label(__('Name') . " ({$language})")
                ->required()
                ->when($language === 'en', fn(TextInput $input) => $input
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))));
        }
        return $translationsSection->schema($translationsSchema);
    }
}
