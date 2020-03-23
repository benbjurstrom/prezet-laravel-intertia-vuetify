<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email', 50)->unique();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('password');
            $table->string('photo_path', 100)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
