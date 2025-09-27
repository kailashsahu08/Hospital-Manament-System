<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorApiController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return response()->json([
            'status' => true,
            'message' => 'Doctors retrieved successfully',
            'data' => $doctors
        ], 200);
    }

    // Store new doctor
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:doctors',
            'specialization' => 'required|string|max:255',
        ]);

        $doctor = Doctor::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Doctor created successfully',
            'data' => $doctor
        ], 201);
    }

    public function show($id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json([
                'status' => false,
                'message' => 'Doctor not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Doctor retrieved successfully',
            'data' => $doctor
        ], 200);
    }

    // Update doctor
    public function update(Request $request, $id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json([
                'status' => false,
                'message' => 'Doctor not found'
            ], 404);
        }

        $request->validate([
            'name'  => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:doctors,email,' . $id,
            'specialization' => 'sometimes|required|string|max:255',
        ]);

        $doctor->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Doctor updated successfully',
            'data' => $doctor
        ], 200);
    }

    // Delete doctor
    public function destroy($id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json([
                'status' => false,
                'message' => 'Doctor not found'
            ], 404);
        }

        $doctor->delete();

        return response()->json([
            'status' => true,
            'message' => 'Doctor deleted successfully'
        ], 200);
    }
}