<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTeamContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Ensure user has a current team set
            if (!$user->currentTeam()) {
                // If user has teams, set the first one as current
                $firstTeam = $user->teams()->first();
                if ($firstTeam) {
                    $user->switchTeam($firstTeam);
                }
            }
        }

        return $next($request);
    }
}
