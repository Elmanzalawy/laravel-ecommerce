<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Settings\StoreSettings;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                static::getTranslationsSection(),
                Section::make(__('Details'))
                    ->heading('')
                    ->collapsible()
                    ->aside()
                    ->schema([
                        Select::make('categories')
                            ->label(__('Categories'))
                            ->relationship('categories', 'name')
                            ->multiple()
                            ->options(ProductCategory::pluck('name', 'id')),
                        TextInput::make('slug')
                            ->disabled()
                            ->dehydrated()
                            ->reactive()
                            ->default(fn (Get $get) => Str::slug($get('name.en')))
                            ->unique(ignoreRecord: true)
                            ->required(),
                        Toggle::make('is_active'),
                    ]),
                Section::make(__('Pricing & Inventory'))
                    ->collapsible()
                    ->schema([
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('$'),
                        TextInput::make('compare_at_price')
                            ->numeric()
                            ->prefix('$'),
                        TextInput::make('cost_per_item')
                            ->numeric(),
                        TextInput::make('quantity')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ]),
            ]);
    }

    public static function getTranslationsSection(): Component
    {
        $storeLanguages = app(StoreSettings::class)->store_languages;
        $translationsSection = Section::make(__('Translations'))
            ->collapsible()
            ->collapsed(false)
            ->columns(2)
            ->schema($translationsSchema = []);

        foreach ($storeLanguages as $language) {
            $translationsSchema[] = TextInput::make("name.{$language}")
                ->default(fn (?Product $record) => $record?->name[$language] ?? null)
                ->label(__("product.name.$language"))
                ->required()
                ->when($language === 'en', fn (TextInput $input) => $input
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))));
        }

        foreach ($storeLanguages as $language) {
            $translationsSchema[] = Textarea::make("description.{$language}")
                ->default(fn (?Product $record) => $record?->description[$language] ?? null)
                ->label(__('Description')." ({$language})");
        }

        return $translationsSection->schema($translationsSchema);
    }
}
