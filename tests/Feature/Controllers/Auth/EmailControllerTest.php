<?php

namespace Tests\Feature\Controllers\Auth;

use App\Mail\EmailChangeVerification;
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

        // Mail::fake([EmailChangeVerification::class]);

        $this->postJson(route('email.update'), [
            'email' => $email,
        ])->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
            'email_pending' => $email,
        ]);

        // Mail::assertQueued(EmailChangeVerification::class);
    }

    /**
     * PATCH
     */
    public function testUpdate()
    {
        $email = $this->faker->email;
        $user = factory(User::class)
            ->states(['withAgreements'])
            ->create(['email_pending' => $email]);
        auth()->login($user);

        $route = URL::signedRoute('auth.email.change.update', [
            'id' => $user->id,
            'email_pending' => $email,
        ]);

        $this->patchJson($route)->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $email,
        ]);
    }
}
