<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Throwable;

class EmailVerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param Request $request
     * @return Response | RedirectResponse
     * @throws AuthorizationException
     */
    public function verify(Request $request)
    {
        if (! hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('settings')->with('success', 'Email Already Verified.');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->route('settings')->with('success', 'Email Verified.');
    }

    /**
     * Resend the email verification notification.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('settings')->with('error', 'Email Already Verified.');
        }

        $request->user()->sendEmailVerificationNotification();

        return redirect()->route('settings')->with('success', 'Verification Resent.');
    }
}
