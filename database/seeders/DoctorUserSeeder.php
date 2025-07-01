<?php

namespace Database\Seeders;

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
        \App\Models\User::factory()->create([
            'name' => 'Doctor User',
            'email' => 'doctor@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('doctor');
    }
}