<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Traits\HasRoleBasedVisibility;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    use HasRoleBasedVisibility;

    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            self::applyAdminVisibility(CreateAction::make()),
        ];
    }
}
