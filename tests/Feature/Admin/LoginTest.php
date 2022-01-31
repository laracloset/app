<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Enums\LoginStatusType;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testLogin()
    {
        $admin = factory(Admin::class)->create([
            'password' => Hash::make('secret')
        ]);

        $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'secret',
        ])->assertRedirect('/admin/home');

        $this->assertAuthenticated('admin');
    }

    /**
     * @return void
     */
    public function testLoginWithInactive()
    {
        $admin = factory(Admin::class)->create([
            'password' => Hash::make('secret'),
            'active' => LoginStatusType::INACTIVE
        ]);

        $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'secret',
        ]);

        $this->assertGuest();
    }
}
