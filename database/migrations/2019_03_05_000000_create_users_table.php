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
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_pending')->nullable();
            $table->boolean('enabled')->default(true);
            $table->string('photo_path', 100)->nullable();
            $table->uuid('current_team_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
