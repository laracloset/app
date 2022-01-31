<?php

namespace Tests\Feature\Admin;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostTest extends AdminTestCase
{
    use DatabaseMigrations;

    public $post;

    public function setUp() :void
    {
        parent::setUp();

        $this->post = factory(Post::class)->create();

        $this->post->each(function ($a) {
            $a->categories()->save(factory(Category::class)->make());
        });
    }

    /**
     * @return void
     */
    public function testIndex()
    {
        $this->get('/admin/posts')
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $this->get('/admin/posts/create')
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testStore()
    {
        $all = Post::all();

        $categories = factory(Category::class, 2)->create();
        $new = factory(Post::class)->make();

        $this->post('/admin/posts', [
            'title' => $new->title,
            'slug' => $new->slug,
            'body' => $new->body,
            'state' => $new->state,
            'category' => $categories->map(function ($item, $key) {
                return $item->id;
            })->all()
        ])
            ->assertRedirect('/admin/posts');

        $saved = Post::query()->latest('id')->first();

        $this->assertEquals(1, count(Post::all()) - count($all));
        $this->assertEquals(2, $saved->categories->count());
    }

    /**
     * @return void
     */
    public function testStoreWithInvalidState()
    {
        $existing = Post::all()->count();

        $new = factory(Post::class)->make();

        $this->post('/admin/posts', [
            'title' => $new->title,
            'slug' => $new->slug,
            'body' => $new->body,
            'state' => -1
        ]);

        $this->assertEquals(0, Post::all()->count() - $existing);
    }

    /**
     * @return void
     */
    public function testShow()
    {
        $this->get('/admin/posts/' . $this->post->id)
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testShowWithMissing()
    {
        $this->get('/admin/posts/0')
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testEdit()
    {
        $this->get('/admin/posts/' . $this->post->id . '/edit')
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testEditWithMissing()
    {
        $this->get('/admin/posts/0/edit')
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $categories = factory(Category::class, 2)->create();
        $new = factory(Post::class)->make();

        $this->put('/admin/posts/' . $this->post->id, [
            'title' => $new->title,
            'slug' => $new->slug,
            'body' => $new->body,
            'state' => $new->state,
            'category' => $categories->map(function ($item, $key) {
                return $item->id;
            })->all()
        ])
            ->assertRedirect('/admin/posts');

        $updated = Post::query()->find($this->post->id);

        $this->assertEquals($updated->title, $new->title);
        $this->assertEquals(2, $updated->categories->count());
    }

    /**
     * @return void
     */
    public function testUpdateWithMissing()
    {
        $new = factory(Post::class)->make();

        $this->put('/admin/posts/0', [
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
        $this->delete('/admin/posts/' . $this->post->id)
            ->assertRedirect();

        $this->assertNull(Post::query()->find($this->post->id));

        $trashed = Post::query()->withTrashed()->find($this->post->id);
        $this->assertEquals(1, $trashed->categories()->count());
    }

    /**
     * @return void
     */
    public function testDeleteWithMissing()
    {
        $this->delete('/admin/posts/0')
            ->assertNotFound();
    }
}
