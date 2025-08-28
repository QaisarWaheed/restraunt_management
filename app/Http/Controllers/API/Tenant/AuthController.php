<?php

namespace App\Http\Controllers\API\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        Log::info("Login credentials:", $credentials);
        
        if (Auth::guard('tenant')->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) 
            {
                Log::info("Login successful");
            $user = Auth::guard('tenant')->user();
            Log::info($user);
            
            $token = $user->createToken('tenant-token')->plainTextToken;
            Log::info($token);
            
            return response()->json([
                'token' => $token,
                'user' => $user,
                'tenant' => tenant(), // Stancl tenant helper
            ]);
        }
        return response()->json([
            'message' => 'The provided credentials are incorrect.',
            'errors' => ['email' => ['The provided credentials are incorrect.']]
        ], 422);
    }
}
