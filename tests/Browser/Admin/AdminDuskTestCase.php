<?php

namespace Tests\Browser\Admin;

use App\Models\Admin;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

abstract class AdminDuskTestCase extends DuskTestCase
{

    public function setUp() :void
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
