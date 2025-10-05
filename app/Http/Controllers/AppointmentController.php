<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // List all appointments
    public function index()
    {
        return response()->json(Appointment::all());
    }

    // Store a new appointment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'department_id' => 'required|exists:departments,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|string', // coming as "10:39 - 18:18"
            'patient_name' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'description' => 'nullable|string',
            'appointment_type' => 'nullable|string',
        ]);
    
        // Split appointment_time into start_time and end_time
        $timeRange = explode('-', $validated['appointment_time']);
        $start_time = isset($timeRange[0]) ? trim($timeRange[0]) : null;
        $end_time = isset($timeRange[1]) ? trim($timeRange[1]) : null;
    
        // Get the first patient from DB
        $firstPatient = \App\Models\Patient::first();
        if (!$firstPatient) {
            return response()->json(['error' => 'No patient found. Please create a patient first.'], 422);
        }
    
        // Create appointment with mapped fields
        $appointment = Appointment::create([
            'doctor_id' => $validated['doctor_id'],
            'department_id' => $validated['department_id'],
            'patient_id' => $firstPatient->id, // default to first patient
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => 'pending',
            'type' => $validated['appointment_type'] ?? 'in-person',
            'reason' => $validated['description'] ?? null,
            'notes' => null,
            'is_follow_up' => false,
            'previous_appointment_id' => null,
        ]);
    
        return response()->json($appointment, 201);
    }

    // View a specific appointment
    public function show($id)
    {
        return response()->json(Appointment::findOrFail($id));
    }

    // Update an appointment
    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $validated = $request->validate([
            'doctor_id' => 'sometimes|exists:doctors,id',
            'patient_id' => 'sometimes|exists:patients,id',
            'department_id' => 'sometimes|exists:departments,id',
            'appointment_date' => 'sometimes|date',
            'start_time' => 'sometimes',
            'end_time' => 'sometimes',
            'status' => 'nullable|string',
            'type' => 'nullable|string',
            'reason' => 'nullable|string',
            'is_follow_up' => 'boolean',
            'previous_appointment_id' => 'nullable|exists:appointments,id',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return response()->json($appointment);
    }

    // Delete an appointment
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return response()->json(null, 204);
    }
}
