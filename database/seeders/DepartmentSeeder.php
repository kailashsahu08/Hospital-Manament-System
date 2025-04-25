<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Cardiology',
            'Neurology',
            'Pediatrics',
            'Orthopedics',
            'Dermatology',
            'Psychiatry',
            'Oncology',
            'Radiology',
            'Gynecology',
            'Urology',
            'Nephrology',
            'Gastroenterology',
            'Endocrinology',
            'Ophthalmology',
            'Pulmonology',
            'Hematology',
            'ENT',
            'General Surgery',
            'Internal Medicine',
            'Anesthesiology',
        ];

        foreach ($departments as $name) {
            Department::create([
                'name' => $name,
                'description' => $name . ' Department specializing in ' . strtolower($name) . '.',
                'is_active' => true,
            ]);
        }
    }
}
