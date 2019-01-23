<?php

namespace Tests\Feature\Admin;


use App\Admin;
use Tests\TestCase;

abstract class AdminTestCase extends TestCase
{

    public function setUp()
    {
        parent::setUp();

        $this->actingAs(factory(Admin::class)->create());
    }

}
