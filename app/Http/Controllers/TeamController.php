<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    /**
     * Switch the user's current team.
     */
    public function switch(Team $team): RedirectResponse
    {
        $user = Auth::user();

        if (!$user->belongsToTeam($team)) {
            abort(403, 'You do not belong to this team.');
        }

        $user->switchTeam($team);

        return redirect()->back()->with('success', 'Team switched successfully.');
    }

    /**
     * Get all teams for the current user.
     */
    public function index(): array
    {
        return Auth::user()->teams()->get()->toArray();
    }
}
