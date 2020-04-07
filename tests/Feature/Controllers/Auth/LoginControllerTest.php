<?php

namespace Tests\Feature\Controllers\Auth;

use App\Mail\EmailChangeVerification;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\URL;

class LoginControllerTest extends TestCase
{
    /**
     * POST
     */
    public function testStore()
    {
        $user = factory(User::class)->create();

        $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => '123',
        ])
            ->assertStatus(200)
            ->assertUrl('/login')
            ->assertComponent('Dashboard/Index');
    }

    /**
     * POST
     */
    public function testStoreWith2fa()
    {
        $user = factory(User::class)->create();
        $tfa = $user->createTwoFactorAuth();
        $user->confirmTwoFactorAuth($tfa->makeCode('now', -1));

        $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => '123',
        ])
            ->assertUrl('/login')
            ->assertComponent('Auth/TwoFactor')
            ->assertPropValue('email', $user->email)
            ->assertPropValue('password', '123');
    }

    /**
     * POST
     */
    public function testStoreConfirm2fa()
    {
        $user = factory(User::class)->create();
        $tfa = $user->createTwoFactorAuth();
        $user->confirmTwoFactorAuth($tfa->makeCode('now', -1));

        $this->assertTrue($user->hasTwoFactorEnabled());

        $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => '123',
            'code' => $tfa->makeCode(),
        ])
            ->assertStatus(200)
            ->assertComponent('Dashboard/Index');
    }
}
