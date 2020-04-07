<?php

namespace App\Mail\Settings;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class EmailChangeNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new message instance.
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email Change Notification')
            ->markdown('mail')
            ->with([
                'message' =>
                    'We received a request to update your email to ' .
                    $this->user->email_pending .
                    '.
                An email has been sent to that address with further instructions to complete the change.
                If you did not initiate this change you should cancel the request below and immediately update your password.',
                'action' => [
                    'text' => 'Cancel Email Update',
                    'url' => $this->cancellationUrl(),
                ],
            ]);
    }

    /**
     * Get the cancellation URL for the given notifiable.
     *
     * @return string
     */
    protected function cancellationUrl()
    {
        return URL::temporarySignedRoute(
            'email.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $this->user->id,
                'hash' => sha1($this->user->email_pending),
            ],
        );
    }
}
