<?php

namespace Tests\Feature;

use Tests\TestCase;

class AnonTest extends TestCase
{
    /**
     * @return void
     */
    public function testAdminHome()
    {
        $this->get('/admin/home')
            ->assertRedirect('/admin/login');
    }
}
