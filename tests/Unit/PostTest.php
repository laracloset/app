<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testBelongsToMany()
    {
        factory(Post::class)->create()->each(function (Post $post) {
            $post->categories()->saveMany(factory(Category::class, 2)->make());
        });

        /** @var Post $post */
        $post = Post::query()
            ->first();

        $this->assertEquals(2, $post->categories()->count());
        $this->assertInstanceOf(Category::class, $post->categories()->first());
    }

    /**
     * @return void
     */
    public function testSoftDelete()
    {
        $post = factory(Post::class)->create();
        $post->delete();

        $this->assertTrue($post->trashed());
    }
}
