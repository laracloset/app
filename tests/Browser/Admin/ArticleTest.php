<?php

namespace Tests\Browser\Admin;


use App\Article;
use App\Category;
use Faker\Provider\Lorem;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ArticleTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     * @throws \Throwable
     */
    public function testIndex()
    {
        $article = factory(Article::class)->create();

        $this->browse(function (Browser $browser) use ($article) {

            $browser->visit('/admin/articles')
                ->assertTitle('Articles')
                ->assertSee($article->id)
                ->assertSee($article->title)
                ->assertSee($article->created_at);
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testIndexWithSorting()
    {
        $articles = factory(Article::class, 20)->create();

        $this->browse(function (Browser $browser) use ($articles) {
            $browser->visit('/admin/articles')
                ->assertDontSee($articles->first()->title)
                ->assertSee($articles->last()->title);
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testIndexWithPaginating()
    {
        $articles = factory(Article::class, 20)->create();

        $this->browse(function (Browser $browser) use ($articles) {
            $browser->visit('/admin/articles')
                ->assertSeeLink('2');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testAdding()
    {
        $article = factory(Article::class)->make();

        $this->browse(function (Browser $browser) use ($article) {
            $browser->visit('/admin/articles')
                ->clickLink('Create Article')
                ->assertTitle('Create Article')
                ->assertInputValue('title', '')
                ->assertInputValue('slug', '')
                ->assertInputValue('body', '')
                ->assertSelected('category[]', '')
                ->assertSelected('state', '')
                ->type('title', $article->title)
                ->type('slug', $article->slug)
                ->type('body', $article->body)
                ->select('state', $article->state)
                ->click('@add')
                ->assertPathIs('/admin/articles')
                ->assertSee($article->title)
                ->assertSee('The article has been saved.');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testEditing()
    {
        $article = factory(Article::class)->create();
        $article->each(function ($a) {
            $a->categories()->save(factory(Category::class)->make());
        });

        $this->browse(function (Browser $browser) use ($article) {
            $newTitle = Lorem::word();

            $browser->visit('/admin/articles')
                ->clickLink('Edit')
                ->assertTitle('Edit Article')
                ->assertInputValue('title', $article->title)
                ->assertInputValue('slug', $article->slug)
                ->assertInputValue('body', $article->body)
                ->assertSelected('category[]', $article->categories[0]->id)
                ->assertSelected('state', $article->state)
                ->type('title', $newTitle)
                ->click('@update')
                ->assertPathIs('/admin/articles')
                ->assertSee($newTitle)
                ->assertSee('The article has been saved.');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testViewing()
    {
        $article = factory(Article::class)->create();

        $this->browse(function (Browser $browser) use ($article) {
            $browser->visit('/admin/articles')
                ->assertTitle('View Article')
                ->clickLink('View')
                ->assertPathIs('/admin/articles/' . $article->id)
                ->assertSee($article->id)
                ->assertSee($article->title)
                ->assertSee($article->slug)
                ->assertSee($article->body);
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testDeleting()
    {
        $article = factory(Article::class)->create();

        $this->browse(function (Browser $browser) use ($article) {
            $browser->visit('/admin/articles')
                ->click('@delete')
                ->assertDontSee($article->title)
                ->assertPathIs('/admin/articles')
                ->assertSee('The article has been deleted.');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testRequestValidation()
    {
        $this->browse(function (Browser $browser) {
            $existing = factory(Article::class)->create();

            $browser->visit('/admin/articles')
                ->clickLink('Create Article')
                ->click('@add')
                ->assertPathIs('/admin/articles/create')
                ->assertSee('The title field is required.')
                ->assertSee('The body field is required.')
                ->assertSee('The state field is required.');

            // Tests whether slug field is unique or not.
            $browser->visit('/admin/articles')
                ->clickLink('Create Article')
                ->type('slug', $existing->slug)
                ->click('@add')
                ->assertPathIs('/admin/articles/create')
                ->assertSee('The slug has already been taken.');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testFillingFieldsWithOldValues()
    {
        $article = factory(Article::class)->create([
            'state' => Article::PUBLISHED
        ]);
        $article->each(function ($a) {
            $a->categories()->saveMany(factory(Category::class, 2)->make());
        });

        $this->browse(function (Browser $browser) use ($article) {

            // Fill title field with invalid value on create new
            $browser->visit('/admin/articles/create')
                ->type('title', str_repeat('a', 256))
                ->type('slug', 'foo')
                ->type('body', 'bar')
                ->select('category[]', $article->categories[0]->id)
                ->select('state', Article::PUBLISHED)
                ->click('@add')
                ->assertInputValue('title', str_repeat('a', 256))
                ->assertInputValue('slug', 'foo')
                ->assertInputValue('body', 'bar')
                ->assertSelected('category[]', $article->categories[0]->id)
                ->assertSelected('state', Article::PUBLISHED);

            // Fill title field with invalid value on update existing
            $browser->visit('/admin/articles/' . $article->id . '/edit')
                ->type('title', str_repeat('a', 256))
                ->type('slug', 'foo')
                ->type('body', 'bar')
                ->select('category[]', $article->categories[0]->id)
                ->select('state', Article::DRAFT)
                ->click('@update')
                ->assertInputValue('title', str_repeat('a', 256))
                ->assertInputValue('slug', 'foo')
                ->assertInputValue('body', 'bar')
                ->assertSelected('category[]', $article->categories[1]->id)
                ->assertSelected('state', Article::DRAFT);
        });
    }
}
