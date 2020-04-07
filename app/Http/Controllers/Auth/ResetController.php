<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Throwable;

class ResetController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function create()
    {
        return Inertia::render('Auth/Forgot');
    }

    /**
     * Create a new password reset
     *
     * @param Request $request
     * @param  AuthService $as
     * @return RedirectResponse
     * @throws ValidationException
     * @throws Throwable
     */
    public function store(Request $request, AuthService $as)
    {
        $data = $this->validate($request, [
            'email'     => 'required|string|email|max:255'
        ]);

        $user = (new User)->where('email', $data['email'])->first();

        // silently skip if the user is not found for privacy reasons
        if ($user) {
            $as->sendForgotPasswordEmail($user);
        }

        return redirect()->route('auth.login')->with('success', 'A password reset email has been sent.');
    }

    /**
     * Create a new password reset
     *
     * @param User $user
     * @param string $token
     * @return \Inertia\Response
     * @throws Throwable
     */
    public function edit(User $user, string $token)
    {
        throw_unless(Password::tokenExists($user, $token), (new ModelNotFoundException)->setModel(
            $user
        ));

        return Inertia::render('Auth/Reset', [
            'userId' => $user->id,
            'token' => $token
        ]);
    }

    /**
     * Update the password reset
     *
     * @param User $user
     * @param string $token
     * @param Request $request
     * @param  AuthService $as
     * @return RedirectResponse
     * @throws ValidationException
     * @throws Throwable
     */
    public function update(User $user, string $token, Request $request, AuthService $as)
    {
        $this->validate($request, [
            'password'  => 'required|string|min:3',
        ]);

        $user = $as->updatePasswordFromToken($user, $token, $request->password);

        return redirect()->route('auth.login')->with('success', 'Your password has successfully been reset. Please login below.');
    }
}
