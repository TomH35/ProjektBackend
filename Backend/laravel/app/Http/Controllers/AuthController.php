<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'AdminRegistration']]);
    }

    public function AdminRegistration(Request $request)
    {
    $validatedData = $request->validate([
        'meno' => 'required|max:255',
        'priezvisko' => 'required|max:255',
        'email' => 'required|email|max:70|unique:admins',
        'password' => [
            'required',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_])[A-Za-z\d@$!%*?&_]{8,16}$/'
        ],
    ], [
        'password.regex' => 'Password must be 8-16 characters long, contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 symbol.'
    ]);

    $admin = new Admin;
    $admin->meno = $validatedData['meno'];
    $admin->priezvisko = $validatedData['priezvisko'];
    $admin->email = $validatedData['email'];
    $admin->password = Hash::make($validatedData['password']);
    $admin->save();

    return response()->json(['message' => 'Admin registered successfully'], 201);
    }

    

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $admin = Auth::user();

        return $this->respondWithToken($token, $admin);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token, $admin = null)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'admin_id' => $admin ? $admin->id : null,
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}

