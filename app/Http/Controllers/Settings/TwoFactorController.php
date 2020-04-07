<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Mpociot\Reauthenticate\Reauthenticates;

class TwoFactorController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $tfa = $request->user()->createTwoFactorAuth();

        return Inertia::render('Settings/TwoFactor', [
            'twoFactor' => [
                'qrCode' => base64_encode($tfa->toQr()), // As QR Code
                'string' => $tfa->toString(), // As a string
                // 'uri'     => $tfa->toUri(),    // As "otpauth://" URI.
            ],
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|string',
        ]);

        $success = $request->user()->confirmTwoFactorAuth($request->code);

        throw_unless(
            $success,
            ValidationException::withMessages([
                'code' => ['The given code was invalid'],
            ]),
        );

        return redirect()
            ->route('settings')
            ->with('success', 'Two Factor Authentication Has Been Enabled.');
    }

    /**
     * @return RedirectResponse
     */
    public function destroy()
    {
        auth()
            ->user()
            ->disableTwoFactorAuth();
        return redirect()
            ->route('settings')
            ->with('success', 'Two Factor Authentication Has Been Disabled.');
    }
}
