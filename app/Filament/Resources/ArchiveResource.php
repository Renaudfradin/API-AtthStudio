<?php

namespace App\Filament\Resources;

use App\Filament\RelationManagers\DocumentsRelationManager;
use App\Filament\Resources\ArchiveResource\Pages\CreateArchive;
use App\Filament\Resources\ArchiveResource\Pages\EditArchive;
use App\Filament\Resources\ArchiveResource\Pages\ListArchives;
use App\Filament\Resources\ArchiveResource\Pages\ViewArchive;
use App\Models\Archive;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ArchiveResource extends Resource
{
    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $model = Archive::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static string|\UnitEnum|null $navigationGroup = 'Contenu';

    public static function getNavigationLabel(): string
    {
        return __('Archives');
    }

    public static function getModelLabel(): string
    {
        return __('Archive');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Archives');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                    ->label('Contenu')
                    ->required()
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Image')
                    ->disk('scaleway')
                    ->directory('details')
                    ->image()
                    ->downloadable()
                    ->openable(),

                Toggle::make('active')
                    ->onColor('success')
                    ->offColor('danger')
                    ->inline(false),
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
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('active')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('active')
                    ->trueLabel('Oui')
                    ->falseLabel('Non'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArchives::route('/'),
            'create' => CreateArchive::route('/create'),
            'view' => ViewArchive::route('/{record}'),
            'edit' => EditArchive::route('/{record}/edit'),
        ];
    }
}
