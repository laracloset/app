<?php

namespace Tests\Feature\Admin;

use App\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public $category;

    public function setUp()
    {
        parent::setUp();

        $this->category = factory(Category::class)->create();
    }

    /**
     * @return void
     */
    public function testIndex()
    {
        $this->get('/admin/categories')
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $this->get('/admin/categories/create')
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testStore()
    {
        $all = Category::all();

        $new = factory(Category::class)->make();

        $this->post('/admin/categories', [
            'name' => $new->name,
            'slug' => $new->slug,
        ])
            ->assertRedirect('/admin/categories');

        $this->assertEquals(1, count(Category::all()) - count($all));
    }

    /**
     * @return void
     */
    public function testShow()
    {
        $this->get('/admin/categories/' . $this->category->id)
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testEdit()
    {
        $this->get('/admin/categories/' . $this->category->id)
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $new = factory(Category::class)->make();

        $this->put('/admin/categories/' . $this->category->id, [
            'name' => $new->name,
            'slug' => $new->slug,
        ])
            ->assertRedirect('/admin/categories');

        $updated = Category::query()->find($this->category->id);

        $this->assertEquals($updated->title, $new->title);
    }

    /**
     * @return void
     */
    public function testDestroy()
    {
        $this->delete('/admin/categories/' . $this->category->id)
            ->assertRedirect('/admin/categories');

        $this->assertNull(Category::query()->find($this->category->id));
    }
}
