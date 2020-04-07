<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;

class OrganizationsController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Organizations/Index', [
            'organizations' => Auth::user()
                ->account->organizations()
                ->withTrashed()
                ->orderBy('name')
                ->get(['id', 'name', 'phone', 'city', 'deleted_at']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Organizations/Create');
    }

    public function store(): RedirectResponse
    {
        Auth::user()
            ->account->organizations()
            ->create(
                Request::validate([
                    'name' => ['required', 'max:100'],
                    'email' => ['nullable', 'max:50', 'email'],
                    'phone' => ['nullable', 'max:50'],
                    'address' => ['nullable', 'max:150'],
                    'city' => ['nullable', 'max:50'],
                    'region' => ['nullable', 'max:50'],
                    'country' => ['nullable', 'max:2'],
                    'postal_code' => ['nullable', 'max:25'],
                ]),
            );

        return Redirect::route('organizations')->with('success', 'Organization created.');
    }

    public function edit(Organization $organization): Response
    {
        return Inertia::render('Organizations/Edit', [
            'organization' => [
                'id' => $organization->id,
                'name' => $organization->name,
                'email' => $organization->email,
                'phone' => $organization->phone,
                'address' => $organization->address,
                'city' => $organization->city,
                'region' => $organization->region,
                'country' => $organization->country,
                'postal_code' => $organization->postal_code,
                'deleted_at' => $organization->deleted_at,
                'contacts' => $organization
                    ->contacts()
                    ->orderByName()
                    ->get()
                    ->map->only(['id', 'name', 'city', 'phone']),
            ],
        ]);
    }

    public function update(Organization $organization): RedirectResponse
    {
        $organization->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ]),
        );

        return Redirect::route('organizations.edit', $organization)->with('success', 'Organization updated.');
    }

    public function destroy(Organization $organization): RedirectResponse
    {
        $organization->delete();

        return Redirect::route('organizations.edit', $organization)->with('success', 'Organization deleted.');
    }

    public function restore(Organization $organization): RedirectResponse
    {
        $organization->restore();

        return Redirect::route('organizations.edit', $organization)->with('success', 'Organization restored.');
    }
}
