<?php

namespace Tests\Feature\Admin;

use App\Article;
use App\Category;
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

        $this->article->each(function ($a) {
            $a->categories()->save(factory(Category::class)->make());
        });
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

        $categories = factory(Category::class, 2)->create();
        $new = factory(Article::class)->make();

        $this->post('/admin/articles', [
            'title' => $new->title,
            'slug' => $new->slug,
            'body' => $new->body,
            'state' => $new->state,
            'category' => $categories->map(function ($item, $key) {
                return $item->id;
            })->all()
        ])
            ->assertRedirect('/admin/articles');

        $saved = Article::query()->latest('id')->first();

        $this->assertEquals(1, count(Article::all()) - count($all));
        $this->assertEquals(2, $saved->categories->count());
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
    public function testShowWithMissing()
    {
        $this->get('/admin/articles/0')
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testEdit()
    {
        $this->get('/admin/articles/' . $this->article->id . '/edit')
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testEditWithMissing()
    {
        $this->get('/admin/articles/0/edit')
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $categories = factory(Category::class, 2)->create();
        $new = factory(Article::class)->make();

        $this->put('/admin/articles/' . $this->article->id, [
            'title' => $new->title,
            'slug' => $new->slug,
            'body' => $new->body,
            'state' => $new->state,
            'category' => $categories->map(function ($item, $key) {
                return $item->id;
            })->all()
        ])
            ->assertRedirect('/admin/articles');

        $updated = Article::query()->find($this->article->id);

        $this->assertEquals($updated->title, $new->title);
        $this->assertEquals(2, $updated->categories->count());
    }

    /**
     * @return void
     */
    public function testUpdateWithMissing()
    {
        $new = factory(Article::class)->make();

        $this->put('/admin/articles/0', [
            'title' => $new->title,
            'slug' => $new->slug,
            'body' => $new->body,
            'state' => $new->state
        ])
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testDestroy()
    {
        $this->delete('/admin/articles/' . $this->article->id)
            ->assertRedirect('/admin/articles');

        $this->assertNull(Article::query()->find($this->article->id));

        $trashed = Article::query()->withTrashed()->find($this->article->id);
        $this->assertEquals(1, $trashed->categories()->count());
    }

    /**
     * @return void
     */
    public function testDeleteWithMissing()
    {
        $this->delete('/admin/articles/0')
            ->assertNotFound();
    }
}
