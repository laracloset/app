<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

class HomeTest extends AdminTestCase
{
    /**
     * @return void
     */
    public function testIndex()
    {
        $this->get('/admin/home')
            ->assertOk();
    }
}
