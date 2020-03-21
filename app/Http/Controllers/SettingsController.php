<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    public function index()
    {
        return Inertia::render('Organizations/Index', [
            'organizations' => Auth::user()->account->organizations()
                ->withTrashed()
                ->orderBy('name')
                ->get(['id', 'name', 'phone', 'city', 'deleted_at'])
        ]);
    }
}
