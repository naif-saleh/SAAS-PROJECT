<?php

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class ResolveTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        
        // Extract domain/subdomain (e.g., tenant-domain.localhost:8000 -> tenant-domain)
        $domain = $this->extractDomain($host);
        
        // If no subdomain or it's the main domain, allow superadmin access
        if (!$domain) {
            return $next($request);
        }
        
        // Find tenant by domain
        $tenant = Team::where('domain', $domain)
            ->where('is_active', true)
            ->first();
        
        if (!$tenant) {
            abort(404, 'Tenant not found or inactive');
        }
        
        // Store tenant in request for later use
        $request->merge(['tenant' => $tenant]);
        app()->instance('tenant', $tenant);
        
        // Set tenant context in session
        if (auth()->check()) {
            auth()->user()->switchTeam($tenant);
        }
        
        return $next($request);
    }
    
    /**
     * Extract domain/subdomain from host
     */
    private function extractDomain(string $host): ?string
    {
        // Remove port if present (e.g., localhost:8000 -> localhost)
        $host = explode(':', $host)[0];
        
        // If it's 127.0.0.1 or localhost (main domain), return null (no tenant)
        if ($host === '127.0.0.1' || $host === 'localhost') {
            return null;
        }
        
        // For localhost with subdomain, extract subdomain (e.g., tenant.localhost -> tenant)
        if (str_contains($host, 'localhost')) {
            $parts = explode('.', $host);
            if (count($parts) > 1 && $parts[0] !== 'localhost') {
                return $parts[0];
            }
            return null;
        }
        
        // For production, extract subdomain (e.g., tenant.example.com -> tenant)
        $parts = explode('.', $host);
        if (count($parts) > 2) {
            return $parts[0];
        }
        
        return null;
    }
}
