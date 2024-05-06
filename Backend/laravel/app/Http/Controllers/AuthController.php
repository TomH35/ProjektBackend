<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function AdminRegistration(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'meno' => 'required|max:255',
            'priezvisko' => 'required|max:255',
            'email' => 'required|email|max:70|unique:admins',
            'password' => 'required',
        ]);

        // Create a new admin
        $admin = new Admin;

        // Set the admin's attributes
        $admin->meno = $validatedData['meno'];
        $admin->priezvisko = $validatedData['priezvisko'];
        $admin->email = $validatedData['email'];
        $admin->password = Hash::make($validatedData['password']);

        // Save the admin to the database
        $admin->save();

        // Return a response
        return response()->json(['message' => 'Admin registered successfully'], 201);
    }
    public function AdminLogin(Request $request)
    {
        // Validate the incoming request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the admin
        if (!$token = auth('admin')->attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Get the authenticated admin
        $admin = Auth::guard('admin')->user();

        // Return a response with the admin's id and JWT
        return response()->json([
            'admin_id' => $admin->id,
            'token' => $token,
        ]);
    }
}
