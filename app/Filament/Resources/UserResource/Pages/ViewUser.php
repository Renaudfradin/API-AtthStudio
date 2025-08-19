<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Traits\HasRoleBasedVisibility;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    use HasRoleBasedVisibility;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            self::applyAdminVisibility(EditAction::make()),
        ];
    }
}
