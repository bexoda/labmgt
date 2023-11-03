<?php

namespace App\Filament\Resources\LabResultResource\Pages;

use Filament\Actions;
use App\Imports\LabResultImport;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\LabResultResource;
use EightyNine\ExcelImport\ExcelImportAction;

class ListLabResults extends ListRecords
{
    protected static string $resource = LabResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                // ->slideOver()
                ->color("primary")
                ->use(LabResultImport::class),
            Actions\CreateAction::make(),
        ];
    }
}
