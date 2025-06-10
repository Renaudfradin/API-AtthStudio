<?php

namespace App\Filament\Resources;

use App\Filament\RelationManagers\DocumentsRelationManager;
use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
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

class ProjectResource extends Resource
{
    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return __('Projets');
    }

    public static function getModelLabel(): string
    {
        return __('Projet');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Projets');
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

                FileUpload::make('image')
                    ->disk('scaleway')
                    ->directory('details')
                    ->visibility('public')
                    ->image()
                    ->columnSpanFull()
                    ->downloadable()
                    ->openable()
                    ->required(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            DocumentsRelationManager::class,
        ];
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'view' => Pages\ViewProject::route('/{record}'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
