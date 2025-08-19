<?php

namespace App\Filament\Resources\ArchiveResource\Pages;

use App\Filament\Resources\ArchiveResource;
use App\Traits\HasRoleBasedVisibility;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListArchives extends ListRecords
{
    use HasRoleBasedVisibility;

    protected static string $resource = ArchiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            self::applyAdminVisibility(CreateAction::make()),
        ];
    }
}
