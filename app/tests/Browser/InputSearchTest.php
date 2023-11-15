<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class InputSearchTest extends DuskTestCase
{
    /** @test */
    public function it_can_search_by_name_or_email()
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
                ->press('@add-search-row-dropdown')
                ->press('@add-search-row-name')
                ->type('name', 'John Evans')
                ->waitForText('john@grandadevans.com')
                ->press('@remove-search-row-name')
                ->waitUntilMissingText('john@grandadevans.com')
                ->press('@add-search-row-dropdown')
                ->press('@add-search-row-email')
                ->type('email', 'john@grandadevans.com')
                ->waitForText('John Evans');
        });
    }
}
