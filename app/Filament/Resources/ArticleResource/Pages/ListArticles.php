<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Traits\HasRoleBasedVisibility;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListArticles extends ListRecords
{
    use HasRoleBasedVisibility;

    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            self::applyAdminVisibility(CreateAction::make()),
        ];
    }
}
