<?php

namespace App\Http\Controllers\API\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Stancl\Tenancy\Database\Models\Domain;
use App\Models\Tenant;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class TenantController extends Controller
{
    public function register(Request $request)
    {

        DB::beginTransaction();

        try {
            Log::info('Tenant registration started', ['request' => $request->all()]);
            // Validate the database name first
            $subdomain = strtolower($request->subdomain);
            if (!preg_match('/^[a-z0-9][a-z0-9-]*[a-z0-9]$/', $subdomain)) {
                return response()->json([
                    'message' => 'Invalid subdomain format. Use only lowercase letters, numbers, and hyphens.',
                    'errors' => ['subdomain' => ['Invalid format']]
                ], 422);
            }

            $validator = Validator::make($request->all(), [
                'business_name' => 'required|string|max:255',
                'subdomain' => 'required|string|max:255',
                'owner_name' => 'required|string|max:255',
                'owner_email' => 'required|email',
                'password' => 'required|string|min:8',
                'password_confirmation' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Check if domain exists
            if (Domain::where('domain', $subdomain . '.' . config('app.domain'))->exists()) {
                return response()->json([
                    'message' => 'Subdomain already taken.',
                    'errors' => ['subdomain' => ['This subdomain is already in use.']]
                ], 422);
            }
            $tenantId = Str::random(8);
            // Log::info('Tenant ID: ' . $tenantId);
            $tenantId = strtolower(str_replace(' ', '-', $request->business_name));
            // Create tenant
            $tenant = new Tenant();
            $tenant->id = $tenantId;
            $tenant->name = $request->business_name;
            $tenant->business_name = $request->business_name;
            $tenant->subdomain = $subdomain;
            $tenant->owner_name = $request->owner_name;
            $tenant->owner_email = $request->owner_email;
            $tenant->owner_phone = $request->owner_phone ?? null;
            $tenant->address = $request->location['address'] ?? null;
            $tenant->postal_code = $request->location['postal_code'] ?? null;
            $tenant->country = $request->location['country'] ?? null;
            $tenant->state = $request->location['state'] ?? null;
            $tenant->city = $request->location['city'] ?? null;
            $tenant->place_id = $request->location['place_id'] ?? null;
            $tenant->latitude = $request->location['latitude'] ?? null;
            $tenant->longitude = $request->location['longitude'] ?? null;
            $tenant->trial_started_at = now()->format('Y-m-d H:i:s');
            $tenant->trial_ends_at = now()->addDays(14)->format('Y-m-d H:i:s');
            $tenant->database_name = 'tenant_' . $tenantId;
            $tenant->status = 'trial';
            $tenantDatabase = 'tenant_' . $tenantId;
            $tenant->database_name = $tenantDatabase;
            $tenant->data = [

                'business_name' => $request->business_name ?? 'Default Name',
            ];
            $tenant->save();
            Log::info('Tenant record created successfully: ' . $tenant->id);

            // Get a fresh tenant instance
            if (!$tenant) {
                Log::error('Tenant is null before domain creation');
            }

            // Now that the tenant's database is created, switch the connection dynamically
            Config::set('database.connections.tenant.database', $tenantDatabase);

            $domainName = $tenantId.'.'.config('app.domain');
            // Create and associate domain
            $domain = $tenant->domains()->create([
                'domain' => $domainName
            ]);
            Log::info('Domain created', ['domain' => $domain->toArray()]);

            // Initialize tenant
            tenancy()->initialize($tenant);
            Log::info(DB::connection()->getDatabaseName());

            // Now create user and settings in tenant database
            $tenant->run(function () use ($request) {
                // Create admin user
                $tenantUser = User::create([
                    'name' => $request->owner_name,
                    'email' => $request->owner_email,
                    'password' => Hash::make($request->password),
                ]);


                // Reset cached roles and permissions
                app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

                // Create permissions
                $permissions = [

                    // Restaurant Owner permissions
                    'manage_restaurant',
                    'manage_categories',
                    'manage_products',
                    'manage_orders',
                    'manage_staff',
                    'view_reports',
                    'manage_settings'
                ];

                foreach ($permissions as $permission) {
                    Permission::firstOrCreate([
                        'name' => $permission,
                        'guard_name' => 'web'
                    ]);
                }

                // Create roles and assign permissions
                $superUserRole = Role::firstOrCreate(
                    ['name' => 'restaurant_owner'],
                    ['guard_name' => 'web']
                );
                $superUserRole->syncPermissions(Permission::all());

                $tenantUser->assignRole('restaurant_owner');

                $setting = Setting::create([
                    'business_name' => $request->business_name,
                    'address' => $request->location['address'] ?? null,
                    'postal_code' => $request->location['postal_code'] ?? null,
                    'country' => $request->location['country'] ?? null,
                    'state' => $request->location['state'] ?? null,
                    'city' => $request->location['city'] ?? null,
                    'phone' => $request->owner_phone ?? null,
                    'email' => $request->owner_email,
                    'place_id' => $request->location['place_id'] ?? null,
                    'latitude' => $request->location['latitude'] ?? null,
                    'longitude' => $request->location['longitude'] ?? null,
                ]);
                Log::info('Settings created successfully: ' . $setting->id);
            });


            Log::info('Tenant registration completed successfully');

            return response()->json([
                'success' => true,
                'message' => 'Restaurant registered successfully',
                'tenant' => $tenant,
                'domain' => $domain->domain
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Tenant registration failed', [
                'error' => $e->getMessage(),
                // 'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage(),
                'error' => $e->getMessage(),
                // 'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}
