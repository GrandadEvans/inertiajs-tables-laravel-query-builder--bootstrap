<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GlobalSearchTest extends DuskTestCase
{
    /** @test */
    public function it_can_globally_search()
    {
        $this->browse(function (Browser $browser) {
            User::first()->forceFill([
                'name'  => 'John Evans',
                'email' => 'john@grandadevans.com',
            ])->save();

            $users = User::query()
                ->select(['id', 'name', 'email'])
                ->orderBy('name')
                ->get();

            $browser->visit('/users/eloquent')
                ->waitFor('table')
                // First user
                ->assertSeeIn('tr:first-child td:nth-child(1)', $users->get(0)->name)
                ->assertDontSee('John Evans')
                ->type('global', 'John Evans')
                ->waitForText('john@grandadevans.com')
                ->type('global', ' ')
                ->waitUntilMissingText('john@grandadevans.com')
                ->type('global', 'john@grandadevans.com')
                ->waitForText('John Evans');
        });
    }
}
