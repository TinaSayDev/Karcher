<?php

namespace App\Filament\Resources\Posts;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Pages;
use App\Models\Post;
use Filament\Schemas\Components\Form;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Actions\Action;
use BackedEnum;
use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Filament\Resources\Posts\Pages\EditPost;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-folder';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('slug')
                    ->required(),

                Forms\Components\Toggle::make('is_published')
                    ->label('Опубликовано'),

                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Дата публикации'),

                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->label('Изображение')
                    ->disk('public')              // сохраняем в storage/app/public
                    ->directory('posts')          // папка storage/app/public/posts
                    ->visibility('public'),

                Section::make('Русский')
                    ->schema([
                        Forms\Components\TextInput::make('translations.ru.title')->label('Заголовок'),
                        Forms\Components\Textarea::make('translations.ru.excerpt')->label('Краткое описание'),
                        Forms\Components\RichEditor::make('translations.ru.content')->label('Контент'),
                    ])
                    ->collapsible(),

                Section::make('Oʻzbekcha')
                    ->schema([
                        Forms\Components\TextInput::make('translations.uz.title')->label('Sarlavha'),
                        Forms\Components\Textarea::make('translations.uz.excerpt')->label('Qisqa tavsif'),
                        Forms\Components\RichEditor::make('translations.uz.content')->label('Kontent'),
                    ])
                    ->collapsible(),

                Section::make('English')
                    ->schema([
                        Forms\Components\TextInput::make('translations.en.title')->label('Title'),
                        Forms\Components\Textarea::make('translations.en.excerpt')->label('Excerpt'),
                        Forms\Components\RichEditor::make('translations.en.content')->label('Content'),
                    ])
                    ->collapsible(),
            ])
            ->columns(1)
            ->statePath('data');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),

                Tables\Columns\TextColumn::make('ru_title')
                    ->label('Заголовок (RU)')
                    ->getStateUsing(fn($record) => $record->translation('ru')->title ?? '—')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->label('Публ.'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}
