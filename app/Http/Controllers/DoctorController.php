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
    public function create(Request $request)
    {
        info($request->all());
        return "Appointment booked successfully!";
        // Validate incoming data
        // $validated = $request->validate([
        //     'appointment_date' => 'required|date',
        //     'start_time'       => 'required',
        //     'patient_name'     => 'required|string|max:255',
        //     'phone'            => 'required|string|max:15',
        //     'description'      => 'nullable|string|max:1000',
        // ]);

        // // Save appointment
        // $appointment = Appointment::create([
        //     'doctor_id'        => $request->doctor_id ?? null, // if you pass doctor_id from blade
        //     'appointment_date' => $validated['appointment_date'],
        //     'start_time'       => $validated['start_time'],
        //     'end_time'         => date('H:i', strtotime($validated['start_time'] . ' +30 minutes')), // optional logic
        //     'patient_id'       => null, // or Auth::id() if logged in
        //     'status'           => 'pending',
        //     'description'      => $validated['description'],
        // ]);

        // return redirect()->back()->with('success', 'Appointment booked successfully!');
    }
}
