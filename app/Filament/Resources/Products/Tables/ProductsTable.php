<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('translations.name')
                    ->label('Название (RU)')
                    ->getStateUsing(function ($record) {
                        return optional(
                            $record->translations
                                ->where('locale', 'ru')
                                ->first()
                        )->name;
                    })
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category')
                    ->label('Категория')
                    ->getStateUsing(function ($record) {
                        return optional(
                            $record->category?->translations
                                ->where('locale', 'ru')
                                ->first()
                        )->name;
                    })
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
