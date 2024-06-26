<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Imports\ImportClients;
use App\Models\Client;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListClients extends ListRecords
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->color('primary'),
            Actions\CreateAction::make()->label('New Client'),
        ];
    }

    // protected static string $view = 'filament.custom.upload-file';

    // public $file = '';

    // public function save()
    // {

    //     if ($this->file !== '') {
    //         Excel::import(new ImportClients, $this->file);
    //     }

    // Client::create([
    //     'name' => 'new-client',
    //     'email' => 'new-client@gmail.com',
    //     'phone_number' => '0345670323',
    //     'location' => 'Kumasi',
    // ]);
    // }

    //     protected function getHeader()
    //     {
    //         return view('filament.custom.upload-file');
    //     }

}
