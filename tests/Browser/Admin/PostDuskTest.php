<?php

namespace Tests\Browser\Admin;


use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\Category;
use Faker\Provider\Lorem;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;

class PostDuskTest extends AdminDuskTestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     * @throws \Throwable
     */
    public function testIndex()
    {
        $post = factory(Post::class)->create();

        $this->browse(function (Browser $browser) use ($post) {

            $browser->visit('/admin/posts')
                ->assertTitleContains('Posts')
                ->assertSee($post->id)
                ->assertSee($post->title)
                ->assertSee($post->created_at);
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testIndexWithSorting()
    {
        $posts = factory(Post::class, 20)->create();

        $this->browse(function (Browser $browser) use ($posts) {
            $browser->visit('/admin/posts')
                ->assertDontSee($posts->first()->title)
                ->assertSee($posts->last()->title);
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testIndexWithPaginating()
    {
        $posts = factory(Post::class, 20)->create();

        $this->browse(function (Browser $browser) use ($posts) {
            $browser->visit('/admin/posts')
                ->assertSeeLink('2');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testAdding()
    {
        $post = factory(Post::class)->make();

        $this->browse(function (Browser $browser) use ($post) {
            $browser->visit('/admin/posts')
                ->clickLink('Create Post')
                ->assertTitleContains('Create Post')
                ->assertInputValue('title', '')
                ->assertInputValue('slug', '')
                ->assertInputValue('body', '')
                ->assertSelected('category[]', '')
                ->assertSelected('state', '')
                ->type('title', $post->title)
                ->type('slug', $post->slug)
                ->type('body', $post->body)
                ->select('state', $post->state)
                ->click('@add')
                ->assertPathIs('/admin/posts')
                ->assertSee($post->title)
                ->assertSee('The post has been saved.');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testEditing()
    {
        $post = factory(Post::class)->create();
        $post->each(function ($a) {
            $a->categories()->save(factory(Category::class)->make());
        });

        $this->browse(function (Browser $browser) use ($post) {
            $newTitle = Lorem::word();

            $browser->visit('/admin/posts')
                ->clickLink('Edit')
                ->assertTitleContains('Edit Post')
                ->assertInputValue('title', $post->title)
                ->assertInputValue('slug', $post->slug)
                ->assertInputValue('body', $post->body)
                ->assertSelected('category[]', $post->categories[0]->id)
                ->assertSelected('state', $post->state)
                ->type('title', $newTitle)
                ->click('@update')
                ->assertPathIs('/admin/posts')
                ->assertSee($newTitle)
                ->assertSee('The post has been saved.');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testViewing()
    {
        $post = factory(Post::class)->create();

        $this->browse(function (Browser $browser) use ($post) {
            $browser->visit('/admin/posts')
                ->clickLink('View')
                ->assertTitleContains('View Post')
                ->assertPathIs('/admin/posts/' . $post->id)
                ->assertSee($post->id)
                ->assertSee($post->title)
                ->assertSee($post->slug)
                ->assertSee($post->body);
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testDeleting()
    {
        $post = factory(Post::class)->create();

        $this->browse(function (Browser $browser) use ($post) {
            $browser->visit('/admin/posts')
                ->click('@delete')
                ->assertDontSee($post->title)
                ->assertPathIs('/admin/posts')
                ->assertSee('The post has been deleted.');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testRequestValidation()
    {
        $this->browse(function (Browser $browser) {
            $existing = factory(Post::class)->create();

            $browser->visit('/admin/posts')
                ->clickLink('Create Post')
                ->click('@add')
                ->assertPathIs('/admin/posts/create')
                ->assertSee('The title field is required.')
                ->assertSee('The body field is required.')
                ->assertSee('The state field is required.');

            // Tests whether slug field is unique or not.
            $browser->visit('/admin/posts')
                ->clickLink('Create Post')
                ->type('slug', $existing->slug)
                ->click('@add')
                ->assertPathIs('/admin/posts/create')
                ->assertSee('The slug has already been taken.');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testFillingFieldsWithOldValues()
    {
        $post = factory(Post::class)->create([
            'state' => PostStatus::PUBLISHED
        ]);
        $post->each(function ($a) {
            $a->categories()->saveMany(factory(Category::class, 2)->make());
        });

        $this->browse(function (Browser $browser) use ($post) {

            // Fill title field with invalid value on create new
            $browser->visit('/admin/posts/create')
                ->type('title', str_repeat('a', 256))
                ->type('slug', 'foo')
                ->type('body', 'bar')
                ->select('category[]', $post->categories[0]->id)
                ->select('state', PostStatus::PUBLISHED)
                ->click('@add')
                ->assertInputValue('title', str_repeat('a', 256))
                ->assertInputValue('slug', 'foo')
                ->assertInputValue('body', 'bar')
                ->assertSelected('category[]', $post->categories[0]->id)
                ->assertSelected('state', PostStatus::PUBLISHED);

            // Fill title field with invalid value on update existing
            $browser->visit('/admin/posts/' . $post->id . '/edit')
                ->type('title', str_repeat('a', 256))
                ->type('slug', 'foo')
                ->type('body', 'bar')
                ->select('category[]', $post->categories[0]->id)
                ->select('state', Post::DRAFT)
                ->click('@update')
                ->assertInputValue('title', str_repeat('a', 256))
                ->assertInputValue('slug', 'foo')
                ->assertInputValue('body', 'bar')
                ->assertSelected('category[]', $post->categories[1]->id)
                ->assertSelected('state', Post::DRAFT);
        });
    }
}
