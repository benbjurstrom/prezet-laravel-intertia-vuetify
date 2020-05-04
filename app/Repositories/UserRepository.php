<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\Team;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Throwable;

class UserRepository
{
    /**
     * @param string $email
     * @param string $name
     * @param string $password
     * @return User
     * @throws Throwable
     */
    public function createFromEmail(string $email, string $name, string $password): User
    {
        return \DB::transaction(function () use ($email, $name, $password) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
            ]);

            $this->createPersonalTeam($user);
            return $user;
        });
    }

    /**
     * @param User $user
     * @return Team
     */
    protected function createPersonalTeam(User $user): Team
    {
        $team = new Team();
        $team->owner_id = $user->id;
        $team->name = 'Personal';
        $team->save();

        $team->users()->attach($user, ['role' => 'OWNER', 'id' => Uuid::uuid4()]);

        return $team;
    }
}
