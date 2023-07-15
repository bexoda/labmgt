<?php

namespace App\Filament\Resources\LabResultResource\Pages;

use App\Filament\Resources\LabResultResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLabResults extends ListRecords
{
    protected static string $resource = LabResultResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Lab Result'),
        ];
    }
}