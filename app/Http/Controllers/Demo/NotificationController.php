<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;
use App\Notifications\DemoNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NotificationController extends Controller
{
    public function store(): RedirectResponse
    {
        auth()
            ->user()
            ->notify((new DemoNotification())->delay(now()->addSeconds(10)));

        return redirect()->route('home');
    }
}
