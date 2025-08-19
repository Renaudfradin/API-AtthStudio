<?php

namespace App\Filament\Resources\ArchiveResource\Pages;

use App\Filament\Resources\ArchiveResource;
use App\Traits\HasRoleBasedVisibility;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewArchive extends ViewRecord
{
    use HasRoleBasedVisibility;

    protected static string $resource = ArchiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            self::applyAdminVisibility(EditAction::make()),
        ];
    }
}
