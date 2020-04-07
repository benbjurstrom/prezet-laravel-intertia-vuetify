<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Throwable;

class EmailUpdateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('signed')->only('update');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param EmailService $es
     * @return RedirectResponse
     * @throws ValidationException
     * @throws \Throwable
     */
    public function store(Request $request, EmailService $es)
    {
        $data = $this->validate($request, [
            'email' => 'required|email|max:255',
        ]);

        throw_if($request->user()->email === $data['email'], ValidationException::withMessages([
            'email' => ['The given email is already associated with this account.']
        ]));

        $es->emailChangeRequest($data['email']);

        return redirect()->route('settings')->with('success', 'Additional instructions have been sent to ' . $data['email']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param EmailService $es
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function verify(Request $request, EmailService $es): RedirectResponse
    {
        $user = auth()->user();
        if (! hash_equals((string) $request->route('id'), $user->id)) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->route('hash'), (string) sha1($user->email_pending))) {
            throw new AuthorizationException;
        }

        $user->email = $user->email_pending;
        $user->email_pending = null;
        $user->email_verified_at = Carbon::now();
        $user->save();

        return redirect()->route('settings')->with('success', 'Email change has been canceled.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse
     */
    public function destroy(): RedirectResponse
    {
        $user = $user = auth()->user();
        $user->email_pending = null;
        $user->save();

        return redirect()->route('settings')->with('success', 'Email Canceled.');
    }
}
