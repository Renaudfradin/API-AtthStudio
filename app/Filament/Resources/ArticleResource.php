<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return __('Articles');
    }

    public static function getModelLabel(): string
    {
        return __('Article');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Articles');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->maxLength(255)
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->translateLabel()
                    ->maxLength(255)
                    ->required(),

                MarkdownEditor::make('content')
                    ->required()
                    ->columnSpanFull(),

                Toggle::make('active')
                    ->onColor('success')
                    ->offColor('danger'),

                Select::make('category')
                    ->relationship('categorie', 'title')
                    ->native(false)
                    ->preload()
                    ->searchable()
                    ->required(),

                FileUpload::make('image')
                    // ->disk('scaleway')
                    // ->directory('character')
                    ->image()
                    ->downloadable()
                    ->openable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),

                TextColumn::make('title')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),

                IconColumn::make('active')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('categorie.title')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                TernaryFilter::make('active')
                    ->trueLabel('Oui')
                    ->falseLabel('Non'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'view' => Pages\ViewArticle::route('/{record}'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
