<?php

namespace Tests\Feature\Admin;

use App\Admin;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

abstract class AdminTestCase extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->actingAs(factory(Admin::class)->create());
    }
}
