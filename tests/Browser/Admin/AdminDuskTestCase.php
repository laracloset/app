<?php

namespace Tests\Browser\Admin;


use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

abstract class AdminDuskTestCase extends DuskTestCase
{

    public function setUp()
    {
        parent::setUp();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(factory(Admin::class)->create());
        });
    }
}
