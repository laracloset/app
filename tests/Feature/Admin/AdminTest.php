<?php

namespace Tests\Feature\Admin;

use App\Enums\AdminStatus;
use App\Models\Admin;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminTest extends AdminTestCase
{
    use DatabaseMigrations;

    public $admin;

    public function setUp() :void
    {
        parent::setUp();

        $this->admin = factory(Admin::class)->create();
    }

    /**
     * @return void
     */
    public function testIndex()
    {
        $this->get('/admin/admins')
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $this->get('/admin/admins/create')
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testStore()
    {
        $this->post('/admin/admins', [
            'name' => 'foo',
            'email' => 'test@example.com',
            'active' => AdminStatus::ACTIVE,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ])
            ->assertRedirect('/admin/admins');
    }

    /**
     * @return void
     */
    public function testEdit()
    {
        $this->get('/admin/admins/' . $this->admin->id . '/edit')
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testEditWithMissing()
    {
        $this->get('/admin/admins/0/edit')
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $this->patch('/admin/admins/' . $this->admin->id, [
            'name' => 'aaaaa',
            'email' => 'foo@example.com',
            'active' => AdminStatus::ACTIVE,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ])
            ->assertRedirect('/admin/admins');

        $this->admin->refresh();

        $this->assertEquals($this->admin->name, 'aaaaa');
    }

    /**
     * @return void
     */
    public function testUpdateWithMissing()
    {
        $new = factory(Admin::class)->make();

        $this->put('/admin/admins/0', [
            'name' => $new->name,
            'email' => $new->email,
            'password' => 'secret',
            'password_formation' => 'secret',
        ])
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testDestroy()
    {
        $this->delete('/admin/admins/' . $this->admin->id)
            ->assertRedirect();

        $this->assertDeleted($this->admin);
    }

    /**
     * @return void
     */
    public function testDeleteWithMissing()
    {
        $this->delete('/admin/admins/0')
            ->assertNotFound();
    }
}
