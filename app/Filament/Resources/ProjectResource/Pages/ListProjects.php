<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Traits\HasRoleBasedVisibility;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProjects extends ListRecords
{
    use HasRoleBasedVisibility;

    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            self::applyAdminVisibility(CreateAction::make()),
        ];
    }
}
