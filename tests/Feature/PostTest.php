<?php

namespace Tests\Feature;

use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testGetIndex()
    {
        $this->get('/posts')
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testGetDetail()
    {
        $post = factory(Post::class)->create([
            'state' => PostStatus::PUBLISHED
        ]);

        $this->get('/posts/' . $post->id)
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testGetDetailWithInvalidId()
    {
        $this->get('/posts/0')
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testGetDetailWithDraft()
    {
        $draft = factory(Post::class)->create([
            'state' => PostStatus::DRAFT
        ]);

        $this->get('/posts/' . $draft->id)
            ->assertNotFound();
    }
}
