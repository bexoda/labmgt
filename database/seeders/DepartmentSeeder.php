<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'AssayLab', 'department_slug' => 'ASS'],
            ['name' => 'Geology', 'department_slug' => 'GEO'],
            ['name' => 'Metallurgy', 'department_slug' => 'MET']
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
