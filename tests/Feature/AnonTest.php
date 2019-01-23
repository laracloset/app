<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnonTest extends TestCase
{
    /**
     * @return void
     */
    public function testAdminHome()
    {
        $this->get('/admin/home')
            ->assertRedirect('/login');
    }
}
