<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $tenants = Team::where('personal_team', false)
            ->with('owner')
            ->latest()
            ->paginate(15);
        
        return view('superadmin.tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('superadmin.tenants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:teams,domain',
            'mobile' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        
        return DB::transaction(function () use ($validated) {
            // Create owner user for the tenant
            $owner = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]);
            
            // Assign tenant role to owner
            $owner->assignRole('tenant');
            
            // Create tenant team
            $tenant = Team::create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'domain' => $validated['domain'],
                'mobile' => $validated['mobile'] ?? null,
                'email' => $validated['email'],
                'password' => $validated['password'],
                'owner_id' => $owner->id,
                'personal_team' => false,
                'is_active' => true,
            ]);
            
            // Attach owner to team
            $owner->teams()->attach($tenant, ['role' => 'owner']);
            
            return redirect()
                ->route('superadmin.tenants.index')
                ->with('success', 'Tenant created successfully.');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $tenant): View
    {
        $tenant->load('owner', 'users');
        
        return view('superadmin.tenants.show', compact('tenant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $tenant): View
    {
        return view('superadmin.tenants.edit', compact('tenant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $tenant): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:teams,domain,' . $tenant->id,
            'mobile' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8',
            'is_active' => 'boolean',
        ]);
        
        return DB::transaction(function () use ($validated, $tenant) {
            $tenant->update([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'domain' => $validated['domain'],
                'mobile' => $validated['mobile'] ?? null,
                'email' => $validated['email'],
                'is_active' => $validated['is_active'] ?? $tenant->is_active,
            ]);
            
            // Update password if provided
            if (!empty($validated['password'])) {
                $tenant->password = $validated['password'];
                $tenant->save();
                
                // Also update owner password
                if ($tenant->owner) {
                    $tenant->owner->password = $validated['password'];
                    $tenant->owner->save();
                }
            }
            
            return redirect()
                ->route('superadmin.tenants.index')
                ->with('success', 'Tenant updated successfully.');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $tenant): RedirectResponse
    {
        DB::transaction(function () use ($tenant) {
            // Delete owner user
            if ($tenant->owner) {
                $tenant->owner->delete();
            }
            
            // Delete tenant (cascade will handle team_user)
            $tenant->delete();
        });
        
        return redirect()
            ->route('superadmin.tenants.index')
            ->with('success', 'Tenant deleted successfully.');
    }
}
