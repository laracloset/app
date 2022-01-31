<?php

namespace Tests\Feature\Request\Admin;

use App\Enums\PostStatus;
use App\Http\Requests\Admin\StoreOrUpdatePost;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreOrUpdatePostTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp() :void
    {
        parent::setUp();

        factory(Category::class, 2)->create();
        Category::query()->latest('id')->first()->delete();

        factory(Post::class)->create([
            'slug' => 'foo'
        ]);
    }

    /**
     * @param $field
     * @param $value
     * @param $expected
     * @dataProvider additionProvider
     */
    public function testRules($field, $value, $expected)
    {
        $defaults = [
            'title' => 'foo',
            'slug' => 'bar',
            'body' => 'baz',
            'state' => PostStatus::PUBLISHED,
            'category' => [],
        ];
        $data = array_merge($defaults, [$field => $value]);

        $request = new StoreOrUpdatePost();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertEquals($expected, $validator->passes());
    }

    /**
     * @return array
     */
    public function additionProvider()
    {
        return [
            'title' => ['title', str_repeat('a', 255), true],
            'blank_title' => ['title', '', false],
            'exceeded_title_length' => ['title', str_repeat('a', 256), false],
            'slug' => ['slug', str_repeat('a', 255), true],
            'blank_slug' => ['slug', '', false],
            'exceeded_slug_length' => ['slug', str_repeat('a', 256), false],
            'duplicated_slug' => ['slug', 'foo', false],
            'body' => ['body', 'foo', true],
            'blank_body' => ['body', '', false],
            'blank_category' => ['category', [], true],
            'category' => ['category', [1], true],
            'invalid_category' => ['category', [-1], false],
            'deleted_category' => ['category', [2], false],
            'state' => ['state', PostStatus::PUBLISHED, true],
            'blank_state' => ['state', '', false],
            'invalid_state' => ['state', 'invalid_state', false],
        ];
    }
}
