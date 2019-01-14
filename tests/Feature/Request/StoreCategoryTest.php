<?php

namespace Tests\Feature\Request;

use App\Category;
use App\Http\Requests\StoreCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreCategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        factory(Category::class)->create([
            'slug' => 'foo'
        ]);

        factory(Category::class)->create([
            'slug' => 'bar'
        ]);
        Category::query()->latest('id')->first()->delete();
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
            'name' => 'baz',
            'slug' => 'qux',
            'parent_id' => 1,
        ];
        $data = array_merge($defaults, [$field => $value]);

        $request = new StoreCategory();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertEquals($expected, $validator->passes());
    }

    public function additionProvider()
    {
        return [
            'name' => ['name', str_repeat('a', 255), true],
            'exceeded_name_limit' => ['name', str_repeat('a', 256), false],
            'slug' => ['slug', str_repeat('a', 255), true],
            'exceeded_slug_limit' => ['slug', str_repeat('a', 256), false],
            'duplicated_slug' => ['slug', 'foo', false],
            'blank_category' => ['parent_id', null, true],
            'invalid_category' => ['parent_id', -1, false],
            'deleted_category' => ['parent_id', 2, false],
        ];
    }
}
