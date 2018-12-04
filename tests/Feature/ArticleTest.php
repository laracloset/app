<?php

namespace Tests\Feature;

use App\Article;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetIndex()
    {
        $this->get('/articles')
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testGetDetail()
    {
        $article = factory(Article::class)->create();

        $this->get('/articles/' . $article->id)
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testGetDetailWithInvalidId()
    {
        $this->get('/articles/0')
            ->assertNotFound();
    }
}
