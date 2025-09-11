<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PatientUserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Patient::create([
            'first_name' => 'Alice',
            'last_name' => 'Smith',
            'email' => 'patient@example.com',
            'phone' => '9876543212',
            'city' => 'Delhi',
            'state' => 'Delhi',
            'gender' => 'female',
            'blood_group' => 'O+',
            'date_of_birth' => '1995-05-10',
            'height' => 165,
            'weight' => 60,
        ]);
    }
} 