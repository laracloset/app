<?php

namespace Tests\Feature\Admin;

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
