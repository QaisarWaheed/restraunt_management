<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $query = Tenant::query();

        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->has('status')) {
            $query->status($request->status);
        }

        $tenants = $query->orderBy('created_at', 'desc')->get();
        Log::info('Tenants fetched successfully', ['tenants' => $tenants]);
        return response()->json([
            'success' => true,
            'data' => $tenants
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'subdomain' => 'required|string|max:255|unique:tenants',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|max:255',
            'logo' => 'nullable|image|max:2048',
            'status' => ['required', Rule::in(['active', 'inactive', 'pending'])]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('tenants', 'public');
            $data['logo'] = $path;
        }

        $tenant = Tenant::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Tenant created successfully',
            'data' => $tenant
        ], 201);
    }

    public function show(Tenant $tenant)
    {
        return response()->json([
            'success' => true,
            'data' => $tenant
        ]);
    }

    public function update(Request $request, Tenant $tenant)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'subdomain' => ['required', 'string', 'max:255', Rule::unique('tenants')->ignore($tenant->id)],
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|max:255',
            'logo' => 'nullable|image|max:2048',
            'status' => ['required', Rule::in(['active', 'inactive', 'pending'])]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($tenant->logo) {
                Storage::disk('public')->delete($tenant->logo);
            }
            $path = $request->file('logo')->store('tenants', 'public');
            $data['logo'] = $path;
        }

        $tenant->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Tenant updated successfully',
            'data' => $tenant
        ]);
    }

    public function destroy(Tenant $tenant)
    {
        if ($tenant->logo) {
            Storage::disk('public')->delete($tenant->logo);
        }
        
        $tenant->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tenant deleted successfully'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(['trial', 'active', 'inactive', 'suspended'])]
        ]);

        $tenant = Tenant::findOrFail($id);
        $tenant->status = $request->status;
        $tenant->save();

        return response()->json([
            'success' => true,
            'message' => 'Tenant status updated successfully',
            'data' => $tenant
        ]);
    }
} 