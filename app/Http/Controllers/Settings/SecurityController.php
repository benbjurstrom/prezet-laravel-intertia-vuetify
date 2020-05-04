<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use Inertia\Inertia;
use Inertia\Response;

class SecurityController extends Controller
{
    public function __invoke(): Response
    {
        $user = auth()->user();

        return Inertia::render('Settings/Index', [
            'title' => 'Settings > Security',
            'tabs' => [
                ['label' => 'Email', 'route' => 'settings.email'],
                ['label' => 'Security'],
                ['label' => 'Teams', 'route' => 'settings.teams'],
            ],
            'user' => $user,
            'twoFactor' => $user->hasTwoFactorEnabled(),
        ]);
    }
}
