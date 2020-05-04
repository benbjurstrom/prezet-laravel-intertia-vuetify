<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use Inertia\Inertia;
use Inertia\Response;

class TeamController extends Controller
{
    public function __invoke(): Response
    {
        $user = auth()->user();

        $teams = $user->teams()->paginate(10);

        return Inertia::render('Settings/Index', [
            'title' => 'Settings > Teams',
            'tabs' => [
                ['label' => 'Email', 'route' => 'settings.email'],
                ['label' => 'Security', 'route' => 'settings.security'],
                ['label' => 'Teams'],
            ],
            'teams' => $teams,
        ]);
    }
}
