<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages\CreateArticle;
use App\Filament\Resources\ArticleResource\Pages\EditArticle;
use App\Filament\Resources\ArticleResource\Pages\ListArticles;
use App\Filament\Resources\ArticleResource\Pages\ViewArticle;
use App\Models\Article;
use App\Traits\HasRoleBasedVisibility;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
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

class ArticleResource extends Resource
{
    use HasRoleBasedVisibility;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $model = Article::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static string|\UnitEnum|null $navigationGroup = 'Contenu';

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

                TextInput::make('time_read')
                    ->label('Temps de lecture')
                    ->numeric()
                    ->required(),

                Select::make('category_id')
                    ->relationship('categorie', 'title')
                    ->native(false)
                    ->preload()
                    ->searchable()
                    ->required(),

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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            ->recordActions([
                ViewAction::make(),
                self::applyAdminVisibility(EditAction::make()),
                self::applyAdminVisibility(DeleteAction::make()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    self::applyAdminVisibility(DeleteBulkAction::make()),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArticles::route('/'),
            'create' => CreateArticle::route('/create'),
            'view' => ViewArticle::route('/{record}'),
            'edit' => EditArticle::route('/{record}/edit'),
        ];
    }
}
