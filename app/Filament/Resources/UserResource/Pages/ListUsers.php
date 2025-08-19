<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Traits\HasRoleBasedVisibility;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    use HasRoleBasedVisibility;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            self::applyAdminVisibility(CreateAction::make()),
        ];
    }
}
