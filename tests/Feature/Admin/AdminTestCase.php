<?php

namespace Tests\Feature\Admin;


use App\User;
use Tests\TestCase;

abstract class AdminTestCase extends TestCase
{

    public function setUp()
    {
        parent::setUp();

        $this->actingAs(factory(User::class)->create());
    }

}
