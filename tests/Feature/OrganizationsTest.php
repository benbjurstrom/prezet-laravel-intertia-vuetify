<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Contact;
use App\Models\Account;
use Tests\TestCase;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrganizationsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $account = Account::create(['name' => 'Acme Corporation']);

        $this->user = factory(User::class)->create([
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'owner' => true,
        ]);
    }

    public function testCanViewOrganizations()
    {
        $this->user->account->organizations()->saveMany(
            factory(Organization::class, 5)->make()
        );

        $this->actingAs($this->user)
            ->get('/organizations')
            ->assertStatus(200)
            ->assertPropCount('organizations.data', 5)
            ->assertPropValue('organizations.data', function ($organizations) {
                $this->assertEquals(
                    ['id', 'name', 'phone', 'city', 'deleted_at'],
                    array_keys($organizations[0])
                );
            });
    }

    public function testCanSearchForOrganizations()
    {
        $this->user->account->organizations()->saveMany(
            factory(Organization::class, 5)->make()
        )->first()->update(['name' => 'Some Big Fancy Company Name']);

        $this->actingAs($this->user)
            ->get('/organizations?search=Some Big Fancy Company Name')
            ->assertStatus(200)
            ->assertPropValue('filters.search', 'Some Big Fancy Company Name')
            ->assertPropCount('organizations.data', 1)
            ->assertPropValue('organizations.data', function ($organizations) {
                $this->assertEquals('Some Big Fancy Company Name', $organizations[0]['name']);
            });
    }

    public function testCannotViewDeletedOrganizations()
    {
        $this->user->account->organizations()->saveMany(
            factory(Organization::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/organizations')
            ->assertStatus(200)
            ->assertPropCount('organizations.data', 4);
    }

    public function testCanFilterToViewDeletedOrganizations()
    {
        $this->user->account->organizations()->saveMany(
            factory(Organization::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/organizations?trashed=with')
            ->assertStatus(200)
            ->assertPropValue('filters.trashed', 'with')
            ->assertPropCount('organizations.data', 5);
    }
}
