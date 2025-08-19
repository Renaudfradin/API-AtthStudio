<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Traits\HasRoleBasedVisibility;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewArticle extends ViewRecord
{
    use HasRoleBasedVisibility;

    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            self::applyAdminVisibility(EditAction::make()),
        ];
    }
}
