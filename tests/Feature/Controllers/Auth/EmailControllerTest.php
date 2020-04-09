<?php

namespace Tests\Feature\Controllers\Auth;

use App\Mail\Settings\EmailChangeVerification;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\URL;

class EmailControllerTest extends TestCase
{
    /**
     * PATCH
     */
    public function testStore()
    {
        $email = $this->faker->email;

        $user = factory(User::class)->create();
        auth()->login($user);

        Mail::fake([EmailChangeVerification::class]);

        $this->followingRedirects()
            ->post(route('email.update'), [
                'email' => $email,
            ])
            ->dump()
            ->assertStatus(200)
            ->assertComponent('Settings/Index')
            ->assertPropValue('user.email_pending', $email);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
            'email_pending' => $email,
        ]);

        Mail::assertQueued(EmailChangeVerification::class);
    }

    /**
     * PATCH
     */
    public function testUpdate()
    {
        $email = $this->faker->email;
        $user = factory(User::class)->create(['email_pending' => $email]);
        auth()->login($user);

        $route = URL::signedRoute('email.verify', [
            'id' => $user->id,
            'hash' => sha1($email),
        ]);

        $this->followingRedirects()
            ->get($route)
            ->assertStatus(200)
            ->assertComponent('Settings/Index')
            ->assertPropValue('user.email', $email)
            ->assertPropValue('user.email_pending', null);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $email,
        ]);
    }
}
