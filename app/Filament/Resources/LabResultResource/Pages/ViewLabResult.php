<?php

namespace App\Filament\Resources\LabResultResource\Pages;

use App\Filament\Resources\LabResultResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLabResult extends ViewRecord
{
    protected static string $resource = LabResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
