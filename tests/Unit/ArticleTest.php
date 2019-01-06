<?php

namespace Tests\Unit;

use App\Article;
use App\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testBelongsToMany()
    {
        factory(Article::class)->create()->each(function (Article $article) {
            $article->categories()->saveMany(factory(Category::class, 2)->make());
        });

        /** @var Article $article */
        $article = Article::query()
            ->first();

        $this->assertEquals(2, $article->categories()->count());
        $this->assertInstanceOf(Category::class, $article->categories()->first());
    }

    /**
     * @return void
     */
    public function testSoftDelete()
    {
        $article = factory(Article::class)->create();
        $article->delete();

        $this->assertTrue($article->trashed());
    }
}
