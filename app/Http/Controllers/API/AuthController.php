<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\TenantWelcomeEmail;
use App\Mail\TenantRegistrationNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function checkSubdomain($subdomain)
    {
        $tenant = \App\Models\Tenant::where('domain', $subdomain)->first();
        
        return response()->json([
            'exists' => (bool) $tenant,
            'tenant' => $tenant ? [
                'name' => $tenant->name,
                'domain' => $tenant->domain,
            ] : null
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'restaurantName' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:tenants,domain',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'required|string',
            'street' => 'required|string',
            'postalCode' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'county' => 'required|string',
        ]);

        // Create tenant
        $tenant = Tenant::create([
            'id' => $request->domain,
            'name' => $request->restaurantName,
            'domain' => $request->domain,
            'status' => 'trial',
            'trial_ends_at' => now()->addDays(14),
            'data' => [
                'address' => $request->address,
                'street' => $request->street,
                'postalCode' => $request->postalCode,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'county' => $request->county,
            ]
        ]);

        // Create tenant admin user
        $user = User::create([
            'name' => $request->restaurantName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'tenant_id' => $tenant->id,
        ]);

        // Assign restaurant owner role
        $user->assignRole('restaurant_owner');

        // Send welcome email to tenant
        Mail::to($user->email)->send(new TenantWelcomeEmail($tenant, $user));

        // Send notification to super admin
        $superAdmin = User::role('super_user')->first();
        if ($superAdmin) {
            Mail::to($superAdmin->email)->send(new TenantRegistrationNotification($tenant, $user));
        }

        // Create token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registration successful!',
            'data' => [
                'user' => $user,
                'tenant' => $tenant,
                'token' => $token,
            ],
            'redirect_url' => route('tenant.dashboard'),
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'subdomain' => 'nullable|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Check if we're on main domain or subdomain
        if ($request->subdomain) {
            // Tenant domain login
            $tenant = Tenant::where('domain', $request->subdomain)->first();
            
            if (!$tenant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid tenant domain'
                ], 404);
            }

            // Verify user belongs to this tenant
            if ($user->tenant_id !== $tenant->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have access to this restaurant'
                ], 403);
            }

            // Verify user has restaurant_owner role
            if (!$user->hasRole('restaurant_owner')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient permissions'
                ], 403);
            }
        } else {
            // Main domain login - must be super user
            if (!$user->hasRole('super_user')) {
                return response()->json([
                    'success' => false,
                    'message' => 'This login is for super users only'
                ], 403);
            }
        }

        // Delete existing tokens
        $user->tokens()->delete();

        // Create new token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Get user's roles and permissions
        $roles = $user->roles->pluck('name');
        $permissions = $user->getAllPermissions()->pluck('name');

        // Get tenant information if user is associated with a tenant
        $tenant = null;
        if ($user->tenant_id) {
            $tenant = $user->tenant;
        }

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $roles,
                'permissions' => $permissions,
                'tenant' => $tenant ? [
                    'id' => $tenant->id,
                    'name' => $tenant->name,
                    'domain' => $tenant->domain,
                ] : null,
            ],
            'redirect_url' => $this->getRedirectUrl($roles, $tenant)
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ]);
    }

    private function getRedirectUrl($roles, $tenant = null)
    {
        if ($roles->contains('super_user')) {
            return '/dashboard';
        }

        if ($roles->contains('restaurant_owner') && $tenant) {
            return "http://{$tenant->domain}.localhost:5000/dashboard";
        }

        return '/';
    }
} 