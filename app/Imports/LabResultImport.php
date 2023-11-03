<?php

namespace App\Imports;

use App\Models\LabResult;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LabResultImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            LabResult::create([
                'lab_request_id' => $row['job_number'],
                'time' => $row['time'],
                'sample_name' => $row['sample_name'],
                'Mn' => $row['mn'],
                'Sol_Mn' => $row['sol_mn'],
                'Fe' => $row['fe'],
                'B' => $row['b'],
                'MnO2' => $row['mn_o2'],
                'SiO2' => $row['si_o2'],
                'Al2O3' => $row['al2_o3'],
                'P' => $row['p'],
                'MgO' => $row['mg_o'],
                'CaO' => $row['ca_o'],
                'Au' => $row['au'],
            ]);
        }
    }
}
