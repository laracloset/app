<?php

namespace Tests\Feature;

use App\Enums\ArticleStatus;
use App\Models\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use DatabaseMigrations;

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
        $article = factory(Article::class)->create([
            'state' => ArticleStatus::PUBLISHED
        ]);

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

    /**
     * @return void
     */
    public function testGetDetailWithDraft()
    {
        $draft = factory(Article::class)->create([
            'state' => ArticleStatus::DRAFT
        ]);

        $this->get('/articles/' . $draft->id)
            ->assertNotFound();
    }
}
