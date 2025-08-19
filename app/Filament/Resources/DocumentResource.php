<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages\CreateDocument;
use App\Filament\Resources\DocumentResource\Pages\EditDocument;
use App\Filament\Resources\DocumentResource\Pages\ListDocuments;
use App\Filament\Resources\DocumentResource\Pages\ViewDocument;
use App\Models\Document;
use App\Traits\HasRoleBasedVisibility;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class DocumentResource extends Resource
{
    use HasRoleBasedVisibility;

    protected static ?string $model = Document::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-c-document';

    public static function canViewAny(): bool
    {
        return self::isCurrentUserAdmin();
    }

    protected static string|\UnitEnum|null $navigationGroup = 'Contenu';

    public static function getNavigationLabel(): string
    {
        return __('Images');
    }

    public static function getModelLabel(): string
    {
        return __('Image');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Images');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image')
                    ->disk('scaleway')
                    ->directory('documents')
                    ->image()
                    ->columnSpanFull()
                    ->downloadable()
                    ->openable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->disk('scaleway'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDocuments::route('/'),
            'create' => CreateDocument::route('/create'),
            'view' => ViewDocument::route('/{record}'),
            'edit' => EditDocument::route('/{record}/edit'),
        ];
    }
}
