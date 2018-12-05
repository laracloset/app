<?php

namespace Tests\Feature\Admin;

use App\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use DatabaseMigrations;

    public $article;

    public function setUp()
    {
        parent::setUp();

        $this->article = factory(Article::class)->create();
    }

    /**
     * @return void
     */
    public function testIndex()
    {
        $this->get('/admin/articles')
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $this->get('/admin/articles/create')
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testStore()
    {
        $all = Article::all();

        $new = factory(Article::class)->make();

        $this->post('/admin/articles', [
            'title' => $new->title,
            'slug' => $new->slug,
            'body' => $new->body,
            'state' => $new->state,
        ])
            ->assertRedirect('/admin/articles');

        $this->assertEquals(1, count(Article::all()) - count($all));
    }

    /**
     * @return void
     */
    public function testShow()
    {
        $this->get('/admin/articles/' . $this->article->id)
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testEdit()
    {
        $this->get('/admin/articles/' . $this->article->id)
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $new = factory(Article::class)->make();

        $this->put('/admin/articles/' . $this->article->id, [
            'title' => $new->title,
            'slug' => $new->slug,
            'body' => $new->body,
            'state' => $new->state,
        ])
            ->assertRedirect('/admin/articles');

        $updated = Article::query()->find($this->article->id);

        $this->assertEquals($updated->title, $new->title);
    }

    /**
     * @return void
     */
    public function testDestroy()
    {
        $this->delete('/admin/articles/' . $this->article->id)
            ->assertRedirect('/admin/articles');

        $this->assertNull(Article::query()->find($this->article->id));
    }
}
