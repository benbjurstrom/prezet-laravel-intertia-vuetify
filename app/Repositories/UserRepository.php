<?php


namespace App\Repositories;


use App\Models\Account;
use App\Models\User;

class UserRepository
{
    /**
     * @param $email string
     * @param $name string
     * @param $password string
     * @return User
     */
    public function createFromEmail($email, $name, $password): User {
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
