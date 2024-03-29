<?php

namespace Tests\Browser\Admin;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ForgotPasswordTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     * @throws \Throwable
     */
    public function testResetPassword()
    {
        $admin = factory(Admin::class)->create();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit('/admin/login')
                ->clickLink('Forgot Your Password?')
                ->assertPathIs('/admin/password/reset')
                ->type('email', $admin->email)
                ->click('@send_password_reset_link')
                ->assertPathIs('/admin/password/reset')
                ->assertSee('e-mailed');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testResetNonAdminPassword()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/admin/login')
                ->clickLink('Forgot Your Password?')
                ->assertPathIs('/admin/password/reset')
                ->type('email', $user->email)
                ->click('@send_password_reset_link')
                ->assertPathIs('/admin/password/reset')
                ->assertDontSee('e-mailed');
        });
    }
}
