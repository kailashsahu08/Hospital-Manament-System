<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'contact_number' => 'required|string|max:25',
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
    
        // Create user
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        $patient = Patient::withoutEvents(function () use ($user, $request) {
            return Patient::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->contact_number,
                'address' => $request->address ?? '',
                'city' => $request->city ?? '',
                'state' => $request->state ?? '',
                'zip_code' => $request->zip_code ?? '',
                'gender' => $request->gender ?? '',
            ]);
        });
    
        $token = $user->createToken('patient_token')->plainTextToken;
    
        return response()->json([
            'success' => true,
            'user' => $user,
            'patient' => $patient,
            'token' => $token,
        ], 201);
    }

    // Patient login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 401);
        }

        $token = $user->createToken('patient_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token,
        ]);
    }

    // Logout user
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ]);
    }

    // Get authenticated user info
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
