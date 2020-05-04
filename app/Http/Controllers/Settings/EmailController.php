<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use Inertia\Inertia;
use Inertia\Response;

class EmailController extends Controller
{
    public function __invoke(): Response
    {
        $user = auth()->user();

        return Inertia::render('Settings/Index', [
            'title' => 'Settings > Email',
            'tabs' => [
                ['label' => 'Email'],
                ['label' => 'Security', 'route' => 'settings.security'],
                ['label' => 'Teams', 'route' => 'settings.teams'],
            ],
            'user' => $user,
        ]);
    }
}
