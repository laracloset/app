<?php

namespace Tests\Browser;

use App\Article;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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
            $browser->visit('/articles')
                ->assertTitleContains('Articles')
                ->assertSee($article->title);
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testDetail()
    {
        $article = factory(Article::class)->create();

        $this->browse(function (Browser $browser) use ($article) {
            $browser->visit('/articles/' . $article->id)
                ->assertTitleContains($article->title)
                ->assertSee($article->title)
                ->assertSee($article->body);
        });
    }
}
