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
       
        $validatedData = $request->validate([
            'meno' => 'required|max:255',
            'priezvisko' => 'required|max:255',
            'email' => 'required|email|max:70|unique:admins',
            'password' => 'required',
        ]);

  
        $admin = new Admin;

     
        $admin->meno = $validatedData['meno'];
        $admin->priezvisko = $validatedData['priezvisko'];
        $admin->email = $validatedData['email'];
        $admin->password = Hash::make($validatedData['password']);

     
        $admin->save();

   
        return response()->json(['message' => 'Admin registered successfully'], 201);
    }
   
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $admin = Auth::user();

        return $this->respondWithToken($token, $admin);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $admin)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'admin_id' => $admin->id,
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
