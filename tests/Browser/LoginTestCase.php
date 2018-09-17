<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTestCase extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     * @throws \Throwable
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/auth/login')
                ->type('email', 'mihailg1093@gmail.com')
                ->type('password', '656215')
                ->press('Login')
                ->assertPathIs('/');
        });

        $this->browse(function ($first) {
            $first->loginAs(User::find(1))
                ->visit('/');
        });
    }
}
