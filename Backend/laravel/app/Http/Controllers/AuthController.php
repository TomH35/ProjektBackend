<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
}
