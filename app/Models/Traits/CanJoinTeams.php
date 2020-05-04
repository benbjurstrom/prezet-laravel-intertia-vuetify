<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use InvalidArgumentException;
use App\Models\Team;

trait CanJoinTeams
{
    /**
     * Determine if the user is a member of any teams.
     *
     * @return bool
     */
    public function hasTeams(): bool
    {
        return count($this->teams) > 0;
    }

    /**
     * Get all of the teams that the user belongs to.
     * @return BelongsToMany<Team>
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_users', 'user_id', 'team_id')
            ->withPivot(['role'])
            ->orderBy('name', 'asc');
    }

    //    /**
    //     * Get all of the pending invitations for the user.
    //     */
    //    public function invitations()
    //    {
    //        return $this->hasMany(Invitation::class);
    //    }

    /**
     * Determine if the user is on the given team.
     *
     * @param Team  $team
     * @return bool
     */
    public function onTeam($team)
    {
        return $this->teams->contains($team);
    }

    /**
     * Determine if the given team is owned by the user.
     *
     * @param  Team  $team
     * @return bool
     */
    public function ownsTeam($team): bool
    {
        return $this->id && $team->owner_id && $this->id === $team->owner_id;
    }

    /**
     * Get all of the teams that the user owns.
     * @return HasMany<Team>
     */
    public function ownedTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'owner_id');
    }

    /**
     * Get the user's role on a given team.
     *
     * @param  mixed  $team
     * @return string | void
     */
    public function roleOn($team)
    {
        if ($team = $this->teams->find($team->id)) {
            return $team->getRelationValue('pivot')->role;
        }
    }

    /**
     * Accessor for the currentTeam method.
     *
     * @return Model|null
     */
    public function getCurrentTeamAttribute()
    {
        return $this->currentTeam();
    }

    /**
     * Get the team that user is currently viewing.
     *
     * @return Team | null
     */
    public function currentTeam()
    {
        if (is_null($this->current_team_id) && $this->hasTeams()) {
            $this->switchToTeam($this->teams->first());

            return $this->currentTeam();
        } elseif (!is_null($this->current_team_id)) {
            $currentTeam = $this->teams->find($this->current_team_id);

            return $currentTeam ?: $this->refreshCurrentTeam();
        }

        return null;
    }

    /**
     * Determine if the user owns the current team.
     *
     * @return bool
     */
    public function ownsCurrentTeam()
    {
        return $this->currentTeam() && $this->currentTeam()->owner_id === $this->id;
    }

    /**
     * Switch the current team for the user.
     *
     * @param  Team  $team
     * @return void
     */
    public function switchToTeam($team)
    {
        if (!$this->onTeam($team)) {
            throw new InvalidArgumentException('User does not belong to team.');
        }

        $this->current_team_id = $team->id;

        $this->save();
    }

    /**
     * Refresh the current team for the user.
     *
     * @return Team | null
     */
    public function refreshCurrentTeam()
    {
        $this->current_team_id = null;

        $this->save();

        return $this->currentTeam();
    }
}
