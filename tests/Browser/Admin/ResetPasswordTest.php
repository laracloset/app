<?php

namespace Tests\Browser\Admin;

use App\Admin;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Password;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class ResetPasswordTest extends DuskTestCase
{
    use DatabaseMigrations;

    const ORIGINAL_PASSWORD = 'secret';
    const NEW_PASSWORD = 'new_password';

    /**
     * @return void
     * @throws \Throwable
     */
    public function testSubmitPasswordReset()
    {
        $admin = factory(Admin::class)->create([
            'password' => bcrypt(self::ORIGINAL_PASSWORD)
        ]);

        $token = Password::broker('admins')->createToken($admin);

        $this->browse(function (Browser $browser) use ($admin, $token) {

            $browser->visit('/admin/password/reset/' . $token)
                ->type('email', $admin->email)
                ->type('password', self::NEW_PASSWORD)
                ->type('password_confirmation', self::NEW_PASSWORD)
                ->click('@reset_password')
                ->assertPathIs('/admin/')
                ->assertSee('has been reset');
        });
    }
}
