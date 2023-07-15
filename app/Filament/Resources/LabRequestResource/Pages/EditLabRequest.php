<?php

namespace App\Filament\Resources\LabRequestResource\Pages;

use App\Filament\Resources\LabRequestResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLabRequest extends EditRecord
{
    protected static string $resource = LabRequestResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
