<?php

namespace App\Filament\RelationManagers;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                // DocumentColumn::originalName()
                //     ->iconColor('primary')
                //     ->wrap()
                //     ->icon('heroicon-o-document')
                //     ->weight(FontWeight::SemiBold)
                //     ->url(fn (Document $record): ?string => $record->original_name ? $record->url : null)
                //     ->openUrlInNewTab(),

                // DocumentColumn::nature(),

                // DocumentColumn::locale(),

                // DocumentColumn::publicationDate(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->filters([
                // DocumentFilter::locale(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
