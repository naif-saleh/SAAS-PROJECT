<?php

namespace App\Models\Concerns;

use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

trait BelongsToTeam
{
    /**
     * Boot the trait.
     */
    protected static function bootBelongsToTeam(): void
    {
        static::addGlobalScope('team', function (Builder $builder) {
            if (Auth::check()) {
                $team = Auth::user()->currentTeam();
                if ($team) {
                    $builder->where('team_id', $team->id);
                }
            }
        });

        static::creating(function ($model) {
            if (Auth::check() && !isset($model->team_id)) {
                $team = Auth::user()->currentTeam();
                if ($team) {
                    $model->team_id = $team->id;
                }
            }
        });
    }

    /**
     * Get the team that owns the model.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Scope a query to only include models for a specific team.
     */
    public function scopeForTeam(Builder $query, Team $team): Builder
    {
        return $query->where('team_id', $team->id);
    }
}
