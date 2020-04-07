<?php


namespace App\Repositories;


use App\Models\Account;
use App\Models\User;
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
    public function createFromEmail(string $email, string $name, string $password): User {
        return \DB::transaction(function () use ($email, $name, $password) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
            ]);

            return $user;
        });
    }
}
