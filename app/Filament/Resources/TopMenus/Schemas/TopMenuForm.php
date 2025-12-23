<?php

namespace App\Filament\Resources\TopMenus\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TopMenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('link1')
                    ->required(),
            ]);
    }
}
