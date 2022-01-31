<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

abstract class AdminTestCase extends TestCase
{
    use DatabaseMigrations;

    public function setUp() :void
    {
        parent::setUp();

        $this->actingAs(factory(Admin::class)->create(), 'admin');
    }
}
