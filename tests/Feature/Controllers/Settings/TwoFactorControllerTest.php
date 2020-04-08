<?php

namespace Tests\Feature\Controllers\Settings;

use App\Mail\EmailChangeVerification;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\URL;

class TwoFactorControllerTest extends TestCase
{
    /**
     * GET
     */
    public function testCreate()
    {
        $user = factory(User::class)->create();
        auth()->login($user);

        $this->get(route('settings.2fa.create'))
            ->assertStatus(200)
            ->assertPropValue('twoFactor.string', $user->twoFactorAuth->toString());
    }

    /**
     * STORE
     */
    public function testStore()
    {
        $user = factory(User::class)->create();
        $tfa = $user->createTwoFactorAuth();
        auth()->login($user);

        $this->assertFalse($user->hasTwoFactorEnabled());

        $this->followingRedirects()
            ->postJson(route('settings.2fa.store'), ['code' => $tfa->makeCode()])
            ->assertComponent('Settings/Index')
            ->assertPropValue('twoFactor', true);

        $this->assertTrue($user->hasTwoFactorEnabled());
    }
}
