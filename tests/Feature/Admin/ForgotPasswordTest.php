<?php

namespace Tests\Feature\Admin;

use App\Enums\LoginStatusType;
use App\Models\Admin;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testSendResetLinkEmail()
    {
        $admin = factory(Admin::class)->create();

        $this->post('/admin/password/email', [
            'email' => $admin->email
        ])
            ->assertSessionHas('status', 'We have e-mailed your password reset link!');
    }

    /**
     * @return void
     */
    public function testSendResetLinkEmailWithInactive()
    {
        $admin = factory(Admin::class)->create([
            'active' => LoginStatusType::INACTIVE
        ]);

        $this->post('/admin/password/email', [
            'email' => $admin->email
        ])
            ->assertSessionHasErrors('email');
    }
}
