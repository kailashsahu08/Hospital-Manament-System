<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function getAlDoctors()
    {
        $doctors =  Doctor::all();
        return view('doctor', compact('doctors'));
    }

    public function viewAppointments($doctorId)
    {
        $doctor = Doctor::findOrFail($doctorId);

        // Example: Fetch appointments of this doctor (if you have an Appointment model)
        $appointments = Appointment::where('doctor_id', $doctor->id)->get();

        // Example: Availability flag (customize logic as you like)
        $isAvailable = $appointments->count() < 10; // just for demo: available if less than 10 appointments

        return view('doctors.appointments.view', compact('doctor', 'appointments', 'isAvailable'));
    }
}
