<?php

namespace App\Filament\Widgets;

use App\Models\Archive;
use App\Models\Article;
use App\Models\Category;
use App\Models\Document;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Projects', Project::count()),
            Stat::make('Total Articles', Article::count()),
            Stat::make('Total Archives', Archive::count()),
            Stat::make('Total Categories', Category::count()),
            Stat::make('Total Documents', Document::count()),
        ];
    }
}
