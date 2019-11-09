<?php

namespace Tests\Unit;

use App\Admin;
use App\Enums\LoginStatusType;
use Tests\TestCase;

class AdminTest extends TestCase
{
    /**
     * @return void
     */
    public function testIsActive()
    {
        $this->assertFalse(factory(Admin::class)->create(['active' => LoginStatusType::INACTIVE])->isActive());
        $this->assertTrue(factory(Admin::class)->create(['active' => LoginStatusType::ACTIVE])->isActive());
    }
}
