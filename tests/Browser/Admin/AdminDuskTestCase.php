<?php

namespace Tests\Browser\Admin;

use App\Admin;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

abstract class AdminDuskTestCase extends DuskTestCase
{

    public function setUp()
    {
        parent::setUp();

        try {
            $this->browse(function (Browser $browser) {
                $browser->loginAs(factory(Admin::class)->create(), 'admin');
            });
        } catch (\Throwable $e) {
            echo $e->getMessage() . "\n";
        }
    }
}
