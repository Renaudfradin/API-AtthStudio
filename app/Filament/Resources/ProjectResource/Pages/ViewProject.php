<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Traits\HasRoleBasedVisibility;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProject extends ViewRecord
{
    use HasRoleBasedVisibility;

    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            self::applyAdminVisibility(EditAction::make()),
        ];
    }
}
