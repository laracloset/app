<?php

namespace Tests\Feature\Admin;

use App\Admin;
use App\Enums\LoginStatusType;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class InactiveAdminTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testIndex()
    {
        $this->actingAs(factory(Admin::class)->create([
            'active' => LoginStatusType::INACTIVE
        ]), 'admin');

        $this->get('/admin/')
            ->assertForbidden();
    }
}
