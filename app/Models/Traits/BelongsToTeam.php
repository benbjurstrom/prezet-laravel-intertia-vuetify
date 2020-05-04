<?php

namespace App\Models\Traits;

use App\Models\Observers\TeamIdObserver;
use App\Models\Scopes\TeamForeignKeyScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Team;

trait BelongsToTeam
{
    public static function bootBelongsToTeam()
    {
        // limits writes
        $class = get_called_class();
        $class::observe(new TeamIdObserver());

        // limits reads
        static::addGlobalScope(new TeamForeignKeyScope());
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    |
    |
    */

    //

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    |
    |
    */

    /**
     * Get the team that owns the valid account.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    |
    |
    */

    /**
     * @param Builder $query
     * @param Team $team
     * @return Builder
     */
    public function scopeTeamFilter(Builder $query, Team $team = null)
    {
        if (!empty($team)) {
            $query->where('team_id', $team->id);
        }

        return $query;
    }
}
