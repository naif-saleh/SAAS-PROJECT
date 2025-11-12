<?php

use App\Http\Controllers\SuperAdmin\AuthController;
use App\Http\Controllers\SuperAdmin\TenantController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

// Superadmin routes (main domain only)
Route::middleware([\App\Http\Middleware\ResolveTenant::class])->group(function () {
    // Superadmin login (route /)
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('superadmin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('superadmin.login.post');
    
    // Superadmin protected routes
    Route::middleware(['auth', \App\Http\Middleware\EnsureSuperAdmin::class])->group(function () {
        Route::get('/superadmin/dashboard', function () {
            return view('superadmin.dashboard');
        })->name('superadmin.dashboard');
        
        Route::resource('superadmin/tenants', TenantController::class)->names([
            'index' => 'superadmin.tenants.index',
            'create' => 'superadmin.tenants.create',
            'store' => 'superadmin.tenants.store',
            'show' => 'superadmin.tenants.show',
            'edit' => 'superadmin.tenants.edit',
            'update' => 'superadmin.tenants.update',
            'destroy' => 'superadmin.tenants.destroy',
        ]);
        
        Route::post('/superadmin/logout', [AuthController::class, 'logout'])->name('superadmin.logout');
    });
});

// Tenant routes (subdomain access)
Route::middleware([\App\Http\Middleware\ResolveTenant::class])->group(function () {
    // Tenant login at root (/) when on tenant subdomain
    Route::get('/', function () {
        $tenant = app('tenant');
        if (!$tenant) {
            abort(404, 'Tenant not found');
        }
        
        // If already logged in and belongs to this tenant, redirect to dashboard
        if (auth()->check() && auth()->user()->belongsToTeam($tenant)) {
            return redirect('/dashboard');
        }
        
        return view('tenant.auth.login', compact('tenant'));
    })->name('tenant.login');
    
    Route::post('/login', function (\Illuminate\Http\Request $request) {
        $tenant = app('tenant');
        if (!$tenant) {
            abort(404, 'Tenant not found');
        }
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // Check tenant credentials
        if ($tenant->email === $request->email && \Illuminate\Support\Facades\Hash::check($request->password, $tenant->password)) {
            // Login as tenant owner
            \Illuminate\Support\Facades\Auth::login($tenant->owner);
            $tenant->owner->switchTeam($tenant);
            
            $request->session()->regenerate();
            
            return redirect('/dashboard');
        }
        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    })->name('tenant.login.post');
});

// Tenant dashboard route (always registered, protected by middleware)
Route::middleware([\App\Http\Middleware\ResolveTenant::class, 'auth'])->get('/dashboard', function () {
    $tenant = app('tenant');
    if (!$tenant) {
        abort(404, 'Tenant not found');
    }
    return view('tenant.dashboard');
})->name('tenant.dashboard');

// Original routes (for backward compatibility, but will be tenant-scoped)
Route::get('/home', function () {
    return redirect()->route('tenant.dashboard');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');

    // Team routes
    Route::post('teams/{team}/switch', [TeamController::class, 'switch'])->name('teams.switch');
    Route::get('teams', [TeamController::class, 'index'])->name('teams.index');
});
