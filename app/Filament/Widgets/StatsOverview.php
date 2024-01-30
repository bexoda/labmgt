<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use App\Models\LabRequest;
use App\Models\LabResult;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Clients', Client::all()->count()),
            // ->description('32k increase')
            // ->descriptionIcon('heroicon-m-arrow-trending-up')
            // ->color('success'),
            Stat::make('Lab Requests', LabRequest::all()->count()),
            // ->description('7% increase')
            // ->descriptionIcon('heroicon-m-arrow-trending-down')
            // ->color('danger'),
            Stat::make('Lab Results', LabResult::all()->count()),
            // ->description('3% increase')
            // ->descriptionIcon('heroicon-m-arrow-trending-up')
            // ->color('success'),
        ];
    }
}
