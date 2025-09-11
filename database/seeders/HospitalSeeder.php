<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    public function run(): void
    {
        Hospital::create([
            'name' => 'City Care Hospital',
            'code' => 'CCH001',
            'email' => 'info@citycare.com',
            'phone' => '9876543210',
            'address' => '123 MG Road',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'zip_code' => '400001',
            'country' => 'India',
            'website' => 'https://citycare.com',
            'license_number' => 'LIC123456',
            'type' => 'private',
            'total_beds' => 200,
            'available_beds' => 150,
            'description' => 'A multi-specialty private hospital.',
            'facilities' => json_encode(['ICU', 'Emergency', 'Pharmacy']),
            'is_active' => true,
            'is_24_hours' => true,
        ]);
    }
}
