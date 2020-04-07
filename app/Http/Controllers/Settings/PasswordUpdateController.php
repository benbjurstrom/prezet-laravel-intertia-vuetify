<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Mail\Settings\PasswordChangeNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;

class PasswordUpdateController extends Controller
{
    public function update(): RedirectResponse
    {
        $data = Request::validate([
            'password'  => 'required|string|min:3',
        ]);

        $user = auth()->user();
        $user->password = $data['password'];
        $user->save();

        Mail::to($user)->queue(new PasswordChangeNotification($user));

        return redirect()->route('settings')->with('success', 'Password updated.');
    }
}
