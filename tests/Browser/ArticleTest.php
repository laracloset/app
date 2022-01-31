<?php

namespace Tests\Browser;

use App\Models\Article;
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
        $articles = factory(Article::class, 20)->create();

        $this->browse(function (Browser $browser) use ($articles) {
            $browser->visit('/articles')
                ->assertDontSee($articles->first()->title)
                ->assertSee($articles->last()->title)
                ->assertTitleContains('Articles')
                ->assertSee($articles->last()->title)
                ->assertSeeLink('2');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testIndexWithDraft()
    {
        $draft = factory(Article::class)->create([
            'state' => Article::DRAFT
        ]);

        $this->browse(function (Browser $browser) use ($draft) {
            $browser->visit('/articles')
                ->assertDontSee($draft->title);
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
