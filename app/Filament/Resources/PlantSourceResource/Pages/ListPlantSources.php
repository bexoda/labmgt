<?php

namespace App\Filament\Resources\PlantSourceResource\Pages;

use App\Filament\Resources\PlantSourceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlantSources extends ListRecords
{
    protected static string $resource = PlantSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
