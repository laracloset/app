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
                ->assertSee($category->id)
                ->assertSee($category->name)
                ->assertSee($category->created_at);
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testIndexWithSorting()
    {
        $categories = factory(Category::class, 20)->create();

        $this->browse(function (Browser $browser) use ($categories) {
            $browser->visit('/admin/categories')
                ->assertDontSee($categories->first()->name)
                ->assertSee($categories->last()->name);
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testIndexWithPaginating()
    {
        $categories = factory(Category::class, 20)->create();

        $this->browse(function (Browser $browser) use ($categories) {
            $browser->visit('/admin/categories')
                ->assertSeeLink('2');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testAdding()
    {
        $category = factory(Category::class)->make();

        $this->browse(function (Browser $browser) use ($category) {
            $browser->visit('/admin/categories')
                ->clickLink('Create Category')
                ->type('name', $category->name)
                ->type('slug', $category->slug)
                ->click('@add')
                ->assertPathIs('/admin/categories')
                ->assertSee($category->name);
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testEditing()
    {
        $category = factory(Category::class)->create();

        $this->browse(function (Browser $browser) use ($category) {
            $newTitle = Lorem::word();

            $browser->visit('/admin/categories')
                ->clickLink('Edit')
                ->type('name', $newTitle)
                ->click('@update')
                ->assertPathIs('/admin/categories')
                ->assertSee($newTitle);
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testViewing()
    {
        $category = factory(Category::class)->create();

        $this->browse(function (Browser $browser) use ($category) {
            $browser->visit('/admin/categories')
                ->clickLink('View')
                ->assertPathIs('/admin/categories/' . $category->id)
                ->assertSee($category->id)
                ->assertSee($category->name)
                ->assertSee($category->slug);
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
                ->assertPathIs('/admin/categories')
                ->assertDontSee($category->name);
        });
    }
}
