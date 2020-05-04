<?php

use App\Models\User;
use App\Models\Contact;
use App\Models\Account;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UsersTableSeeder::class);
    }
}
