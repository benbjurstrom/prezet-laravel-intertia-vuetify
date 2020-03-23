<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    public function update()
    {
        $data = Request::validate([
            'password'      => 'required|string|min:3',
            'password_new'  => 'required|string|min:3',
        ]);

        $user = auth()->user();
        throw_unless(Hash::check($data['password'], $user->password), ValidationException::withMessages([
            'password'    => ['The given credentials are incorrect']
        ]));

        $user->password = $data['password_new'];
        $user->save();

        return Redirect::route('home')->with('success', 'Password updated.');
    }
}
