<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportClients implements ToModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Client([
            'name' => $row[0],
            'email' => $row[1],
            'phone_number' => $row[2],
            'location' => $row[3],
        ]);
    }
}
