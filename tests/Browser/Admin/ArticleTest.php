<?php

namespace Tests\Browser\Admin;


use App\Article;
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
                ->type('title', $article->title)
                ->type('slug', $article->slug)
                ->type('body', $article->body)
                ->select('state', $article->state)
                ->click('@add')
                ->assertPathIs('/admin/articles')
                ->assertSee($article->title);
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testEditing()
    {
        $article = factory(Article::class)->create();

        $this->browse(function (Browser $browser) use ($article) {
            $newTitle = Lorem::word();

            $browser->visit('/admin/articles')
                ->clickLink('Edit')
                ->type('title', $newTitle)
                ->click('@update')
                ->assertPathIs('/admin/articles')
                ->assertSee($newTitle);
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
                ->assertPathIs('/admin/articles')
                ->assertDontSee($article->title);
        });
    }
}
