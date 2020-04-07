<?php

namespace App\Services;

use App\Models\User;
use App\Mail\Settings\PasswordChangeNotification;
use App\Mail\Auth\PasswordReset;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthService
{
    /**
     * @param User $user
     * @param string $token
     * @param string $password
     * @return User
     * @throws Throwable
     */
    public function updatePasswordFromToken(User $user, string $token, string $password): User
    {
        return \DB::transaction(function () use ($user, $token, $password) {
            $user = $this->getTokenUser($user->email, $token);
            $user->password = $password;
            $user->save();

            Password::deleteToken($user);
            Mail::to($user)->queue(new PasswordChangeNotification($user));

            return $user;
        });
    }

    /**
     * @param User $user
     * @throws Throwable
     */
    public function sendForgotPasswordEmail(User $user): void
    {
        Password::deleteToken($user);
        $token = Password::createToken($user);

        Mail::to($user)->queue(new PasswordReset($user, $token));
    }

    /**
     * @param string $email
     * @param string $token
     * @return User
     * @throws Throwable
     */
    public function getTokenUser($email, $token): User
    {
        $user = (new User)
            ->where('email', $email)
            ->first();

        $this->validate(!empty($user));
        $this->validate(Password::tokenExists($user, $token));
        return $user;
    }

    /**
     * @param User $user
     * @return string
     */
    public function getEmailVerificationSignature(User $user)
    {
        $route = URL::signedRoute('auth.email.verify.update', ['id' => $user->id]);
        return substr($route, strrpos($route, '=') + 1);
    }

    /**
     * @param string $password
     * @return User
     * @throws \Throwable
     */
    public function validateAuthenticatedUsersPassword($password): User
    {
        $user = auth()->user();
        throw_unless(Hash::check($password, $user->password), ValidationException::withMessages([
            'password'    => ['The given credentials are incorrect']
        ]));

        return $user;
    }

    /**
     * @param bool $subject
     * @throws \Throwable
     */
    protected function validate($subject): void
    {
        throw_unless($subject, ValidationException::withMessages([
            'token'    => ['The given credentials are incorrect']
        ]));
    }

    protected function validateUserNotVerified(User $user): void
    {
        throw_if($user->hasVerifiedEmail(), ValidationException::withMessages([
            'id'    => ['The current user email address is already verified.']
        ]));
    }
}
