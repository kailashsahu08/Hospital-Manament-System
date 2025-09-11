<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Hospital;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorUserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $hospital = Hospital::first();
        Doctor::create([
            'hospital_id' => $hospital->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'doctor@example.com',
            'phone' => '9876543211',
            'specialization' => 'Cardiology',
            'experience_years' => 10,
            'consultation_fee' => 1000.00,
            'is_verified' => true,
            'is_available' => true,
        ]);
    }
}