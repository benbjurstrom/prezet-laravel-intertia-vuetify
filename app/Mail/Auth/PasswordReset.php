<?php

namespace App\Mail\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * @var string
     */
    protected $token;

    /**
     * Create a new message instance.
     * @param User $user
     * @param string $token
     * @return void
     */
    public function __construct(User $user, $token)
    {
        $this->user  = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Password Reset')
            ->markdown('mail')
            ->with([
                'message' => 'You are receiving this email because we received a password reset request for your account.',
                'action' => [
                    'text' => 'Reset Password',
                    'url' => $this->resetUrl()
                ]
            ]);
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @return string
     */
    protected function resetUrl()
    {
        return URL::temporarySignedRoute(
            'auth.password.reset.update',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'user' => $this->user->id,
                'token' => $this->token,
            ]
        );
    }
}
