<?php

namespace Tests\Browser;

use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PostTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     * @throws \Throwable
     */
    public function testIndex()
    {
        $posts = factory(Post::class, 20)->create();

        $this->browse(function (Browser $browser) use ($posts) {
            $browser->visit('/posts')
                ->assertDontSee($posts->first()->title)
                ->assertSee($posts->last()->title)
                ->assertTitleContains('Posts')
                ->assertSee($posts->last()->title)
                ->assertSeeLink('2');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testIndexWithDraft()
    {
        $draft = factory(Post::class)->create([
            'state' => PostStatus::DRAFT
        ]);

        $this->browse(function (Browser $browser) use ($draft) {
            $browser->visit('/posts')
                ->assertDontSee($draft->title);
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testDetail()
    {
        $post = factory(Post::class)->create();

        $this->browse(function (Browser $browser) use ($post) {
            $browser->visit('/posts/' . $post->id)
                ->assertTitleContains($post->title)
                ->assertSee($post->title)
                ->assertSee($post->body);
        });
    }
}
