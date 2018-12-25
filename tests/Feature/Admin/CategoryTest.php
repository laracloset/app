<?php

namespace Tests\Feature\Admin;

use App\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

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
    public function testStoreAsRoot()
    {
        $category = factory(Category::class)->make();

        $this->post('/admin/categories', [
            'name' => $category->name,
            'slug' => $category->slug,
        ])
            ->assertRedirect('/admin/categories');

        $saved = Category::query()->latest('id')->first();
        $this->assertEquals($category->name, $saved->name);
        $this->assertEquals($category->slug, $saved->slug);
        $this->assertNull($saved->parent_id);
        $this->assertEquals(1, Category::query()->count());
    }

    /**
     * @return void
     */
    public function testStoreAsChild()
    {
        $parent = factory(Category::class)->create();
        $category = factory(Category::class)->make();

        $this->post('/admin/categories', [
            'name' => $category->name,
            'slug' => $category->slug,
            'parent_id' => $parent->id,
        ])
            ->assertRedirect('/admin/categories');

        $saved = Category::query()->latest('id')->first();
        $this->assertEquals($parent->id, $saved->parent_id);
    }

    /**
     * @return void
     */
    public function testShow()
    {
        $category = factory(Category::class)->create();

        $this->get('/admin/categories/' . $category->id)
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testEdit()
    {
        $category = factory(Category::class)->create();

        $this->get('/admin/categories/' . $category->id)
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $category = factory(Category::class)->create();
        $new = factory(Category::class)->make();

        $this->put('/admin/categories/' . $category->id, [
            'name' => $new->name,
            'slug' => $new->slug,
            'parent_id' => $new->parent_id,
        ])
            ->assertRedirect('/admin/categories');

        $updated = Category::query()->find($category->id);

        $this->assertEquals($updated->title, $new->title);
        $this->assertEquals($updated->slug, $new->slug);
        $this->assertEquals($updated->parent_id, $new->parent_id);
    }

    /**
     * @return void
     */
    public function testDestroy()
    {
        $category = factory(Category::class)->create();

        $this->delete('/admin/categories/' . $category->id)
            ->assertRedirect('/admin/categories');

        $this->assertNull(Category::query()->find($category->id));
    }

    /**
     * @return void
     */
    public function testMoveDown()
    {
        list($node1, $node2) = factory(Category::class, 2)->create();

        $this->put('/admin/categories/' . $node1->id . '/move_down')
            ->assertRedirect('/admin/categories');

        $top = Category::query()
            ->orderBy('_lft', 'asc')
            ->first();

        $this->assertEquals($node2->id, $top->id);
    }

    /**
     * @return void
     */
    public function testMoveUp()
    {
        list($node1, $node2) = factory(Category::class, 2)->create();

        $this->put('/admin/categories/' . $node2->id . '/move_up')
            ->assertRedirect('/admin/categories');

        $bottom = Category::query()
            ->orderBy('_lft', 'desc')
            ->first();

        $this->assertEquals($node1->id, $bottom->id);
    }
}