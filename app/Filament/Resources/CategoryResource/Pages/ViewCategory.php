<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Traits\HasRoleBasedVisibility;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCategory extends ViewRecord
{
    use HasRoleBasedVisibility;

    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            self::applyAdminVisibility(EditAction::make()),
        ];
    }
}
