<?php

namespace Tests\Feature\Request\Admin;

use App\Http\Requests\Admin\StoreOrUpdateAsset;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreOrUpdateAssetTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp() :void
    {
        parent::setUp();

        Storage::fake();
    }

    /**
     * @param $field
     * @param $value
     * @param $expected
     * @dataProvider additionProvider
     */
    public function testRules($field, $value, $expected)
    {
        $defaults = [];
        $data = array_merge($defaults, [$field => $value]);

        $request = new StoreOrUpdateAsset();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertEquals($expected, $validator->passes());
    }

    public function additionProvider()
    {
        return [
            'file' => ['file', UploadedFile::fake()->image('avatar.jpg'), true],
            '0Bytes_file' => ['file', UploadedFile::fake()->image('avatar.jpg')->size(0), true],
            'blank_file' => ['file', null, false],
        ];
    }
}
