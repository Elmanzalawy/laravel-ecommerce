<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use App\Settings\StoreSettings;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductInfolist
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
                        TextEntry::make('categories.name')
                            ->badge()
                            ->url(fn ($entry) => "#$entry")
                            ->label(__('Categories')),
                        TextEntry::make('slug'),
                        IconEntry::make('is_active')
                            ->boolean(),

                        Flex::make([
                            TextEntry::make('created_at')
                                ->dateTime()
                                ->placeholder('-'),
                            TextEntry::make('updated_at')
                                ->dateTime()
                                ->placeholder('-'),
                            TextEntry::make('deleted_at')
                                ->dateTime()
                                ->visible(fn (Product $record): bool => $record->trashed()),
                        ]),
                    ]),

                Section::make(__('Pricing & Inventory'))
                    ->collapsible()
                    ->schema([
                        TextEntry::make('price')
                            ->money(),
                        TextEntry::make('compare_at_price')
                            ->money()
                            ->placeholder('-'),
                        TextEntry::make('cost_per_item')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('quantity')
                            ->numeric(),
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
            $translationsSchema[] = TextEntry::make('name')
                ->getStateUsing(fn (?Product $record) => $record->getTranslation('name', $language))
                ->label(__("product.name.$language"));
        }

        foreach ($storeLanguages as $language) {
            $translationsSchema[] = TextEntry::make("description.{$language}")
                ->getStateUsing(fn (?Product $record) => $record->getTranslation('description', $language))
                ->disabled()
                ->label(__("product.description.$language"));
        }

        return $translationsSection->schema($translationsSchema);
    }
}
