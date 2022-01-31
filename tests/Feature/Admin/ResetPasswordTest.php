<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Enums\LoginStatusType;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use DatabaseMigrations;

    const ORIGINAL_PASSWORD = 'secret';
    const NEW_PASSWORD = 'new_password';

    /**
     * @return void
     */
    public function testSubmitPasswordResetRequest()
    {
        $admin = factory(Admin::class)->create([
            'password' => bcrypt(self::ORIGINAL_PASSWORD)
        ]);

        $token = Password::broker('admins')->createToken($admin);

        $this->post('/admin/password/reset', [
            'token' => $token,
            'email' => $admin->email,
            'password' => self::NEW_PASSWORD,
            'password_confirmation' => self::NEW_PASSWORD
        ])->assertRedirect('/admin/home');

        $admin->refresh();

        $this->assertFalse(Hash::check(self::ORIGINAL_PASSWORD, $admin->password));
        $this->assertTrue(Hash::check(self::NEW_PASSWORD, $admin->password));
    }

    /**
     * @return void
     */
    public function testSubmitPasswordResetRequestWithInactive()
    {
        $admin = factory(Admin::class)->create([
            'password' => bcrypt(self::ORIGINAL_PASSWORD),
            'active' => LoginStatusType::INACTIVE,
        ]);

        $token = Password::broker('admins')->createToken($admin);

        $this->post('/admin/password/reset', [
            'token' => $token,
            'email' => $admin->email,
            'password' => self::NEW_PASSWORD,
            'password_confirmation' => self::NEW_PASSWORD
        ])->assertSessionHasErrors('email');
    }
}
