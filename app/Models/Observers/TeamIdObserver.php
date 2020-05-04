<?php

namespace App\Models\Observers;

use App\Exceptions\NotAuthorizedTeam;
use App\Models\Model;
use Throwable;

class TeamIdObserver
{
    /**
     * @param mixed $model
     * @return void
     * @throws Throwable
     */
    public function saving($model): void
    {
        $user = auth()->user();

        if (!$user) {
            return;
        }

        $userTeam = $user->currentTeam();
        $team = $model->team;

        throw_unless(
            $userTeam->is($team),
            new NotAuthorizedTeam($team->id, get_called_class(), 'TeamIdObserver::checkCurrentTeam'),
        );
    }
}
