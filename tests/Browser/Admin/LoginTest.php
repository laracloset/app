<?php

namespace Tests\Browser\Admin;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp() :void
    {
        parent::setUp();

        try {
            $this->browse(function (Browser $browser) {
                $browser->logout('admin');
            });
        } catch (\Throwable $e) {
            echo $e->getMessage() . "\n";
        }
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testLogin()
    {
        $admin = factory(Admin::class)->create();

        $this->browse(function (Browser $browser) use ($admin) {

            $browser->visit('/admin/login')
                ->type('email', $admin->email)
                ->type('password', 'secret')
                ->click('@login')
                ->assertPathIs('/admin/home')
                ->assertSee($admin->name);
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testRedirectAfterLogin()
    {
        $admin = factory(Admin::class)->create();

        $this->browse(function (Browser $browser) use ($admin) {

            $browser->visit('/admin/posts')
                ->assertPathIs('/admin/login')
                ->type('email', $admin->email)
                ->type('password', 'secret')
                ->click('@login')
                ->assertPathIs('/admin/posts');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testLoginWithNonAdmin()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/admin/login')
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->click('@login')
                ->assertPathIs('/admin/login')
                ->assertSee('not match');
        });
    }
}
