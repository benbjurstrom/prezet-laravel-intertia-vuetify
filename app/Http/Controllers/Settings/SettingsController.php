<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Settings/Index', [
            'user' => auth()->user()
        ]);
    }
}
