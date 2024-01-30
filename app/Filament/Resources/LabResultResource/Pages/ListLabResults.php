<?php

namespace App\Filament\Resources\LabResultResource\Pages;

use App\Filament\Resources\LabResultResource;
use App\Imports\LabResultImport;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLabResults extends ListRecords
{
    protected static string $resource = LabResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                // ->slideOver()
                ->color('primary')
                ->use(LabResultImport::class),
            Actions\CreateAction::make(),
        ];
    }
}
