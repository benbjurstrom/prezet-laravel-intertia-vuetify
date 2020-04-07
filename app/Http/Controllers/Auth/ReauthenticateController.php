<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Inertia\Response;
use Mpociot\Reauthenticate\Reauthenticates;

class ReauthenticateController extends Controller
{
    use Reauthenticates;

    /**
     * @return Response
     */
    public function getReauthenticate()
    {
        return Inertia::render('Auth/Reauthenticate');
    }
}
