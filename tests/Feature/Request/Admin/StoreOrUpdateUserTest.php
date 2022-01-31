<?php

namespace Tests\Feature\Request\Admin;

use App\Http\Requests\Admin\StoreOrUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreOrUpdateUserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @param $field
     * @param $value
     * @param $expected
     * @dataProvider additionProvider
     */
    public function testRules($field, $value, $expected)
    {
        $defaults = [
            'name' => 'foo',
            'email' => 'test@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];
        $data = array_merge($defaults, [$field => $value]);

        $request = new StoreOrUser();
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
            'name' => ['name', str_repeat('a', 255), true],
            'blank_name' => ['name', '', false],
            'exceeded_name_length' => ['name', str_repeat('a', 256), false],
            'email' => ['email', 'foo@example.com', true],
            'blank_email' => ['email', '', false],
            'invalid_email' => ['email', 'aaaaa', false],
            'blank_password' => ['password', '', true],
            'below_password_length' => ['password', str_repeat('a', 5), false],
            'not_equals_password' => ['password_confirmation', 'foobarbaz', false],
        ];
    }
}
