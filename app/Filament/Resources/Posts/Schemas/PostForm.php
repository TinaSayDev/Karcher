<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1) // одна колонка — на всю ширину
            ->components([
                TextInput::make('slug')
                    ->required(),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')       // сохраняем на диск public (storage/app/public)
                    ->directory('posts'),
                Toggle::make('is_published')
                    ->required(),
                DateTimePicker::make('published_at'),
                Repeater::make('translations')
                    ->disableItemCreation() // запрет добавления новых записей
                    ->disableItemDeletion() // запрет удаления
                    ->relationship() // автоматически сохранит связи
                    ->columns(1) // одна колонка — на всю ширину
                    ->schema([
                        TextInput::make('locale')
                            ->label('Язык')
                            ->disabled() // не редактируется
                            ->columnSpanFull(), // на всю ширину

                        TextInput::make('title')->required(),
                        Textarea::make('excerpt')
                            ->rows(5)
                            ->required(),
                        RichEditor::make('content')
                            ->label('Контент')
                            ->extraInputAttributes(['style' => 'min-height: 300px;']) // высота в пикселях
                            ->required()
                            ->columnSpanFull()
                            ->fileAttachmentsAcceptedFileTypes(['image/png', 'image/jpeg'])
                            ->fileAttachmentsMaxSize(2000)
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('posts')
                            ->fileAttachmentsVisibility('public')
                    ])
            ]);
    }
}
