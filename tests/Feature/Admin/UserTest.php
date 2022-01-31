<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends AdminTestCase
{
    use DatabaseMigrations;

    public $user;

    public function setUp() :void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
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
        $categories = factory(Category::class, 2)->create();
        $new = factory(User::class)->make();

        $this->put('/admin/users/' . $this->user->id, [
            'title' => $new->title,
            'slug' => $new->slug,
            'body' => $new->body,
            'state' => $new->state,
            'category' => $categories->map(function ($item, $key) {
                return $item->id;
            })->all()
        ])
            ->assertRedirect('/admin/users');

        $updated = User::query()->find($this->user->id);

        $this->assertEquals($updated->title, $new->title);
        $this->assertEquals(2, $updated->categories->count());
    }

    /**
     * @return void
     */
    public function testUpdateWithMissing()
    {
        $new = factory(User::class)->make();

        $this->put('/admin/users/0', [
            'title' => $new->title,
            'slug' => $new->slug,
            'body' => $new->body,
            'state' => $new->state
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

        $this->assertNull(User::query()->find($this->user->id));

        $trashed = User::query()->withTrashed()->find($this->user->id);
        $this->assertEquals(1, $trashed->categories()->count());
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
