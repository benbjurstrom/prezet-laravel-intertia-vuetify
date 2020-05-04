<?php

use App\Models\Team;
use App\Models\Validator;
use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\User;
use App\Models\Asset;
use App\Models\Principal;
use App\Models\Organization;
use Ramsey\Uuid\Uuid;
use ZuluCrypto\StellarSdk\Keypair;
use Base32\Base32;

class TestCaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    }


    /*
    |--------------------------------------------------------------------------
    | Simple Seeders
    |--------------------------------------------------------------------------
    |
    |
    */

    /**
     * @return User
     */
    public function seedUser(): User
    {
        $user = factory(User::class)->create();
        return $user;
    }

    /**
     * @param Team
     * @return User
     */
    public function seedTeam(User $user = null): Team
    {
        if (!$user) {
            $user = $this->seedUser();
        }

        $team = factory(Team::class)->create([
            'owner_id' => $user->id
        ]);

        $team->users()->attach($user,
            ['role' => 'OWNER', 'id' => Uuid::uuid4()]);

        return $team;
    }

    /*
    |--------------------------------------------------------------------------
    | Compound Seeders
    |--------------------------------------------------------------------------
    |
    |
    */

    /**
     * @param Team $team
     * @return User
     * @throws
     */
    public function seedUserWithTeam(Team $team = null): User {
        $user = $this->seedUser();

        // dd($user->id);

        if(!$team){
            $team = $this->seedTeam($user);
        }else{
            $team->users()->attach($user, ['role' => 'OWNER', 'id' => Uuid::uuid4()]);
        }

        return $user->fresh(['teams']);
    }
}
