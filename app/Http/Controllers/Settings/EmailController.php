<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function update()
    {
        $data = Request::validate([
            'email'      => 'required|string|email|unique:users',
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
