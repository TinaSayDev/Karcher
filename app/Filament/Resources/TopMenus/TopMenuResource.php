<?php

namespace App\Filament\Resources\TopMenus;

use App\Filament\Resources\TopMenus\Pages\CreateTopMenu;
use App\Filament\Resources\TopMenus\Pages\EditTopMenu;
use App\Filament\Resources\TopMenus\Pages\ListTopMenus;
use App\Filament\Resources\TopMenus\Schemas\TopMenuForm;
use App\Filament\Resources\TopMenus\Tables\TopMenusTable;
use App\Models\TopMenu;
use BackedEnum;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;


class TopMenuResource extends Resource
{
    protected static ?string $model = TopMenu::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-folder';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('link1')
                ->required()
                ->unique(ignoreRecord: true)
                ->columnSpanFull(),
            TextInput::make('link2')
                ->required()
                ->unique(ignoreRecord: true)
                ->columnSpanFull(),
            TextInput::make('phone')
                ->required()
                ->unique(ignoreRecord: true)
                ->columnSpanFull()
        ]);

    }

    public static function table(Table $table): Table
    {
        return TopMenusTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTopMenus::route('/'),
            'create' => CreateTopMenu::route('/create'),
            'edit' => EditTopMenu::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Соц меню';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Соц меню';
    }

    public static function getNavigationLabel(): string
    {
        return 'Соц меню';
    }

    public static function getNavigationSort(): ?int
    {
        return 2; // порядок внутри группы
    }
}
