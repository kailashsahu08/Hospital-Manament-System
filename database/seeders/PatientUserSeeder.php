<?php

namespace Database\Seeders;

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
        \App\Models\User::factory()->create([
            'name' => 'Patient User',
            'email' => 'patient@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('patient');
    }
} 