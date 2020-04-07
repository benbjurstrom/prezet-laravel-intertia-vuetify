<?php

namespace App\Services;

use App\Mail\Settings\EmailChangeNotification;
use App\Mail\Settings\EmailChangeVerification;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    /**
     * @param string $email
     * @return User
     * @throws \Throwable
     */
    public function emailChangeRequest(string $email): User
    {
        return \DB::transaction(function () use ($email) {
            // Note: we check whether the email already belongs to a user on verification.
            $user = auth()->user();

            // verify email is different
            throw_if(
                $user->email === $email,
                ValidationException::withMessages([
                    'email_pending' => ['The given email is already associated with this account.'],
                ]),
            );

            $user->email_pending = $email;
            $user->save();

            // Only send the mail if the email doesn't already exist
            if (!$this->emailExists($user->email_pending)) {
                // Notify current email
                Mail::to($user)->queue(new EmailChangeNotification($user));

                // Send verification to email_pending
                $user->email = $user->email_pending;
                Mail::to($user)->queue(new EmailChangeVerification($user));
            }

            return $user;
        });
    }

    protected function emailExists(string $email): bool
    {
        return (new User())->where('email', $email)->exists();
    }
}
