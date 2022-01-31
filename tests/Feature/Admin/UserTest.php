<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends AdminTestCase
{
    use DatabaseMigrations;

    public $user;

    public function setUp() :void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * @return void
     */
    public function testIndex()
    {
        $this->get('/admin/users')
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testEdit()
    {
        $this->get('/admin/users/' . $this->user->id . '/edit')
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testEditWithMissing()
    {
        $this->get('/admin/users/0/edit')
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $this->patch('/admin/users/' . $this->user->id, [
            'name' => 'aaaaa',
            'email' => 'foo@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ])
            ->assertRedirect('/admin/users');

        $this->user->refresh();

        $this->assertEquals($this->user->name, 'aaaaa');
    }

    /**
     * @return void
     */
    public function testUpdateWithMissing()
    {
        $new = User::factory()->make();

        $this->put('/admin/users/0', [
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
        $this->delete('/admin/users/' . $this->user->id)
            ->assertRedirect();

        $this->assertDeleted($this->user);
    }

    /**
     * @return void
     */
    public function testDeleteWithMissing()
    {
        $this->delete('/admin/users/0')
            ->assertNotFound();
    }
}
