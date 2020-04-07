<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function __invoke(): Response
    {
        $user = auth()->user();
        return Inertia::render('Settings/Index', [
            'user' => $user,
            'twoFactor' => $user->hasTwoFactorEnabled(),
        ]);
    }
}
