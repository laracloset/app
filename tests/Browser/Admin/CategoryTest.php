<?php

namespace Tests\Browser\Admin;


use App\Category;
use Faker\Provider\Lorem;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CategoryTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     * @throws \Throwable
     */
    public function testIndex()
    {
        $category = factory(Category::class)->create();

        $this->browse(function (Browser $browser) use ($category) {

            $browser->visit('/admin/categories')
                ->assertTitle('Categories')
                ->assertSee($category->id)
                ->assertSee($category->name)
                ->assertSee($category->created_at);
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testIndexHasNoPaginating()
    {
        $categories = factory(Category::class, 20)->create();

        $this->browse(function (Browser $browser) use ($categories) {
            $browser->visit('/admin/categories')
                ->assertDontSeeLink('2')
                ->assertSee($categories[0]->id)
                ->assertSee($categories[19]->id);
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testAddingAsRoot()
    {
        $this->browse(function (Browser $browser) {
            $category = factory(Category::class)->make();

            $browser->visit('/admin/categories')
                ->clickLink('Create Category')
                ->assertTitle('Create Category')
                ->assertInputValue('name', '')
                ->assertInputValue('slug', '')
                ->assertSelected('parent_id', '')
                ->type('name', $category->name)
                ->type('slug', $category->slug)
                ->click('@add')
                ->assertPathIs('/admin/categories')
                ->assertSee($category->name)
                ->assertSee('The category has been saved.');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testAddingAsChild()
    {
        $parent = factory(Category::class)->create();

        $this->browse(function (Browser $browser) use ($parent) {
            $category = factory(Category::class)->make();

            $browser->visit('/admin/categories')
                ->clickLink('Create Category')
                ->type('name', $category->name)
                ->type('slug', $category->slug)
                ->select('parent_id', $parent->id)
                ->click('@add')
                ->assertPathIs('/admin/categories')
                ->assertSee($category->name)
                ->assertSee('The category has been saved.');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testEditing()
    {
        $parent = factory(Category::class)->create();
        $category = factory(Category::class)->create([
            'parent_id' => $parent->id
        ]);

        $this->browse(function (Browser $browser) use ($category) {
            $newTitle = Lorem::word();

            $browser->visit('/admin/categories/' . $category->id . '/edit')
                ->assertTitle('Edit Category')
                ->assertInputValue('name', $category->name)
                ->assertInputValue('slug', $category->slug)
                ->assertSelected('parent_id', $category->parent_id)
                ->type('name', $newTitle)
                ->click('@update')
                ->assertPathIs('/admin/categories')
                ->assertSee($newTitle)
                ->assertSee('The category has been saved.');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testViewing()
    {
        $parent = factory(Category::class)->create();
        $category = factory(Category::class)->create([
            'parent_id' => $parent->id
        ]);

        $this->browse(function (Browser $browser) use ($category) {
            $browser->visit('/admin/categories/' . $category->id)
                ->assertTitle('View Category')
                ->assertSee($category->id)
                ->assertSee($category->name)
                ->assertSee($category->slug)
                ->assertSee($category->parent_id);
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testDeleting()
    {
        $category = factory(Category::class)->create();

        $this->browse(function (Browser $browser) use ($category) {
            $browser->visit('/admin/categories')
                ->click('@delete')
                ->assertDontSee($category->name)
                ->assertPathIs('/admin/categories')
                ->assertSee('The category has been deleted.');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testMoveDown()
    {
        $categories = factory(Category::class, 2)->create();

        $this->browse(function (Browser $browser) use ($categories) {
            $top = $categories[0];
            $bottom = $categories[1];

            $browser->visit('/admin/categories')
                ->click('@move_down_' . $bottom->id)
                ->assertPathIs('/admin/categories')
                ->assertSee('Could not move down.');

            $browser->visit('/admin/categories')
                ->click('@move_down_' . $top->id)
                ->assertPathIs('/admin/categories')
                ->assertSee('Move down successfully.');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testMoveUp()
    {
        $categories = factory(Category::class, 2)->create();

        $this->browse(function (Browser $browser) use ($categories) {
            $top = $categories[0];
            $bottom = $categories[1];

            $browser->visit('/admin/categories')
                ->click('@move_up_' . $top->id)
                ->assertPathIs('/admin/categories')
                ->assertSee('Could not move up.');

            $browser->visit('/admin/categories')
                ->click('@move_up_' . $bottom->id)
                ->assertPathIs('/admin/categories')
                ->assertSee('Move up successfully.');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testRequestValidation()
    {
        $this->browse(function (Browser $browser) {
            $existing = factory(Category::class)->create();

            $browser->visit('/admin/categories')
                ->clickLink('Create Category')
                ->click('@add')
                ->assertPathIs('/admin/categories/create')
                ->assertSee('The name field is required.')
                ->assertSee('The slug field is required.');

            // Tests whether slug field is unique or not.
            $browser->visit('/admin/categories')
                ->clickLink('Create Category')
                ->type('slug', $existing->slug)
                ->click('@add')
                ->assertPathIs('/admin/categories/create')
                ->assertSee('The slug has already been taken.');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testFillingFieldsWithOldValues()
    {
        $category = factory(Category::class)->create();

        $this->browse(function (Browser $browser) use ($category) {

            // Fill name field with invalid value on create new
            $browser->visit('/admin/categories/create')
                ->type('name', str_repeat('a', 256))
                ->type('slug', 'foo')
                ->select('parent_id', $category->id)
                ->click('@add')
                ->assertInputValue('name', str_repeat('a', 256))
                ->assertInputValue('slug', 'foo')
                ->assertSelected('parent_id', $category->id);

            // Fill name field with invalid value on update existing
            $browser->visit('/admin/categories/' . $category->id . '/edit')
                ->type('name', str_repeat('a', 256))
                ->type('slug', 'foo')
                ->select('parent_id', $category->id)
                ->click('@update')
                ->assertInputValue('name', str_repeat('a', 256))
                ->assertInputValue('slug', 'foo')
                ->assertSelected('parent_id', $category->id);
        });
    }
}
