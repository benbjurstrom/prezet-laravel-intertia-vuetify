<?php

namespace App\Listeners;

use App\Exceptions\EnforceTwoFactorAuthException;
use DarkGhostHunter\Laraguard\Contracts\TwoFactorAuthenticatable;
use Illuminate\Validation\ValidationException;

class EnforceTwoFactorAuth extends \DarkGhostHunter\Laraguard\Listeners\EnforceTwoFactorAuth
{
    /**
     * Creates a response containing the Two Factor Authentication view.
     *
     * @param TwoFactorAuthenticatable $user
     * @param bool $error
     * @return void
     * @throws EnforceTwoFactorAuthException
     * @throws \Throwable
     */
    protected function throwResponse(TwoFactorAuthenticatable $user, bool $error = false)
    {
        throw_if(
            $error,
            ValidationException::withMessages([
                'code' => ['The given 2FA Code is invalid.'],
            ]),
        );

        $data = [
            'action' => request()->fullUrl(),
            'credentials' => $this->credentials,
            'user' => $user,
            'error' => $error,
            'remember' => $this->remember,
        ];

        throw new EnforceTwoFactorAuthException($data);
    }
}
