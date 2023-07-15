<?php

namespace App\Filament\Resources\LabRequestResource\Pages;

use App\Filament\Resources\LabRequestResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLabRequests extends ListRecords
{
    protected static string $resource = LabRequestResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Lab Request'),
        ];
    }
}
