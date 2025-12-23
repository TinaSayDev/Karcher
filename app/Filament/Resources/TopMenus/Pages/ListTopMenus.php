<?php

namespace App\Filament\Resources\TopMenus\Pages;

use App\Filament\Resources\TopMenus\TopMenuResource;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Table;

class ListTopMenus extends ListRecords
{
    protected static string $resource = TopMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('link1')
                    ->label('Название')
                    ->state(fn () => 'Соц сети и телефон'),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([]);
    }


}
