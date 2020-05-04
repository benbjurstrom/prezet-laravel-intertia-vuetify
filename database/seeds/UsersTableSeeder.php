<?php

use App\Models\Team;
use Illuminate\Database\Seeder;
use App\Models\User;
use Ramsey\Uuid\Uuid;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws
     */
    public function run()
    {
        $user = factory(User::class)
            ->create([
                'email' => 'user@example.com',
                'password' => env('TEST_PASSWORD', '123')
            ]);

        $teams = factory(Team::class, 50)->create([
            'owner_id' => $user->id
        ]);

        foreach ($teams as $team){
            $team->users()->attach($user, ['role' => 'OWNER', 'id' => Uuid::uuid4()]);
        }
    }
}
