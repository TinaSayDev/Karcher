<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
                    ->searchable(query: function (Builder $query, string $search) {
                        $query->whereHas('translations', function ($q) use ($search) {
                            $q->where('locale', 'ru')
                                ->where('name', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(),

                TextColumn::make('category')
                    ->label('Категория')
                    ->getStateUsing(function ($record) {
                        return optional(
                            $record->category?->translations
                                ->where('locale', 'ru')
                                ->first()
                        )->name;
                    })
                    ->searchable(query: function (Builder $query, string $search) {
                        $query->whereHas('category.translations', function ($q) use ($search) {
                            $q->where('locale', 'ru')
                                ->where('name', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(),

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
