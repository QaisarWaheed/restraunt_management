<?php

namespace App\Http\Controllers\API\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\EmailSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        try {
            $settings = Setting::first();
            
            if (!$settings) {
                $settings = Setting::create([
                    'business_name' => 'My Restaurant',
                    'logo' => null,
                    'address' => '',
                    'postal_code' => '',
                    'country' => '',
                    'state' => '',
                    'city' => '',
                    'phone' => '',
                    'email' => '',
                    'place_id' => '',
                    'pickup_start_end_time' => '',
                    'latitude' => null,
                    'longitude' => null,
                    'currency_symbol' => '$',
                    'timezone' => 'UTC',
                    'date_format' => 'Y-m-d',
                    'time_format' => 'H:i:s',
                    'is_active' => true,
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id()
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $settings
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching settings: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch settings'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'key' => 'required|string|unique:settings',
                'value' => 'required',
                'type' => 'required|string'
            ]);

            $setting = Setting::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Setting created successfully',
                'data' => $setting
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating setting: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create setting'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $setting = Setting::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $setting
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching setting: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Setting not found'
            ], 404);
        }
    }

    public function update(Request $request)
    {
        try {
            Log::info("Request data:", $request->all());
            $validated = $request->validate([
                'business_name' => 'sometimes|required|string|max:255',
                'logo' => 'nullable|string',
                'address' => 'nullable|string',
                'postal_code' => 'nullable|string|max:20',
                'country' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'city' => 'nullable|string|max:100',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'place_id' => 'nullable|string',
                'pickup_start_end_time' => 'nullable|string',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'currency_symbol' => 'sometimes|required|string',
                'timezone' => 'sometimes|required|string|max:255',
                'date_format' => 'sometimes|required|string|max:20',
                'time_format' => 'sometimes|required|string|max:20',
                'is_active' => 'boolean',
                'facebook_link' => 'nullable|url',
                'twitter_link' => 'nullable|url',
                'linkedin_link' => 'nullable|url',
                'google_plus_link' => 'nullable|url',
                'instagram_link' => 'nullable|url',
                'description' => 'nullable|string'
            ]);
            Log::info("Validated data:", $validated);
            $settings = Setting::first();
            Log::info("Settings fetch");
            if (!$settings) {
                $settings = Setting::create($validated
                //  + [
                //     'created_by' => auth()->id(),
                //     'updated_by' => auth()->id()
                // ]
            );
            } else {
                $settings->update($validated 
                // + [
                //     'updated_by' => auth()->id()
                // ]
            );
            }
            Log::info("Settings after update:");
            return response()->json([
                'success' => true,
                'message' => 'Settings updated successfully',
                'data' => $settings
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating settings: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update settings'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $setting = Setting::findOrFail($id);
            $setting->delete();

            return response()->json([
                'success' => true,
                'message' => 'Setting soft deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error soft deleting setting: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to soft delete setting'
            ], 500);
        }
    }

    public function forceDelete($id)
    {
        try {
            $setting = Setting::withTrashed()->findOrFail($id);
            $setting->forceDelete();

            return response()->json([
                'success' => true,
                'message' => 'Setting permanently deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error permanently deleting setting: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to permanently delete setting'
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $setting = Setting::withTrashed()->findOrFail($id);
            $setting->restore();

            return response()->json([
                'success' => true,
                'message' => 'Setting restored successfully',
                'data' => $setting
            ]);
        } catch (\Exception $e) {
            Log::error('Error restoring setting: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to restore setting'
            ], 500);
        }
    }

    public function uploadLogo(Request $request)
    {
        try {
            $request->validate([
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $path = $file->store('logos', 'public');
                
                // Get the full URL for the stored file
                $url = Storage::url($path);

                return response()->json([
                    'success' => true,
                    'url' => $url
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ], 400);
        } catch (\Exception $e) {
            Log::error('Error uploading logo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload logo'
            ], 500);
        }
    }

    public function getDetails()
    {
        Log::info("Fetching public settings");
        try {
            $settings = Setting::first();

            Log::info("Fetching public settings", [$settings]);
            if (!$settings) {
                 return response()->json([
                    'success' => false,
                    'message' => 'Settings not found'
                ], 404);
            }
            return response()->json([
                'success' => true,
                'data' => $settings
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching public settings: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch public settings'
            ], 500);
        }
    }
    public function email_index()
    
    {
        try {
            Log::info('Email setting is fetching');
            $email_setting = EmailSettings::first();
            
            if (!$email_setting) {
                $email_setting = EmailSettings::create([
                    'driver' => '',
                    'host' => '',
                    'port' => '',
                    'username' => '',
                    'password' => '',
                    'email' => '',
                    'encryption' => '',
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $email_setting
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching settings: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch settings'
            ], 500);
        }
    }
    public function save_email_setting(Request $request)
    {
        try {
            Log::info("Request data:", $request->all());
            $validated = $request->validate([
                'driver' => 'nullable|string',
                'host' => 'nullable|string',
                'port' => 'nullable|string',
                'username' => 'nullable|email|string',
                'email' => 'nullable|email|string',
                'password' => 'nullable|string',
                'encryption' => 'nullable|string',
            ]);
            Log::info("Validated data:", $validated);
            $email_settings = EmailSettings::first();
            Log::info("Settings fetch");
            if (!$email_settings) {
                $email_settings = EmailSettings::create($validated
            );
            } else {
                $email_settings->update($validated 
            );
            }
            Log::info("Email Setting after update:");
            return response()->json([
                'success' => true,
                'message' => 'Email Setup updated successfully',
                'data' => $email_settings
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating settings: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update Email'
            ], 500);
        }
    }
    
    public function updateDiscount(Request $request)
    {
        try {
            Log::info("Request data:", $request->all());
            $validated = $request->validate([
                'discount' => 'nullable'
            ]);
            Log::info("Validated data:", $validated);
            $settings = Setting::first();
            Log::info("Settings fetch");
            if (!$settings) {
                $settings = Setting::create($validated
                //  + [
                //     'created_by' => auth()->id(),
                //     'updated_by' => auth()->id()
                // ]
            );
            } else {
                $settings->update($validated 
            );
            }
            Log::info("Settings after update:");
            return response()->json([
                'success' => true,
                'message' => 'Settings updated successfully',
                'data' => $settings
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating settings: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update settings'
            ], 500);
        }
    }
} 