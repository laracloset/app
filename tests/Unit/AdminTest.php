<?php

namespace Tests\Unit;

use App\Enums\LoginStatusType;
use App\Models\Admin;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testIsActive()
    {
        $this->assertFalse(factory(Admin::class)->create(['active' => LoginStatusType::INACTIVE])->isActive());
        $this->assertTrue(factory(Admin::class)->create(['active' => LoginStatusType::ACTIVE])->isActive());
    }
}
