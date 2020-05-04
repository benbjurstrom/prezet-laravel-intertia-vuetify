<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TeamForeignKeyScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  Builder  $builder
     * @param  Mixed  $model
     * @return void
     */
    public function apply(Builder $builder, $model)
    {
        $user = auth()->user();

        if (!$user) {
            return;
        }
        $builder->where($model->getTable() . '.team_id', $user->currentTeam()->id);
    }
}
