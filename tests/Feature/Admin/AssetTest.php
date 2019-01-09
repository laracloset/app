<?php

namespace Tests\Feature\Admin;

use App\Asset;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AssetTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testAvatarUpload()
    {
        Storage::fake();

        $file = UploadedFile::fake()->image('avatar.jpg');

        $this->post('/admin/assets', [
            'file' => $file
        ]);

        $asset = Asset::query()
            ->first();

        // Assert the file was stored...
        Storage::disk()->assertExists('assets/' . $file->hashName());

        $this->assertEquals('Asset', $asset->model);
        $this->assertEquals(null, $asset->foeign_key);
        $this->assertEquals('avatar.jpg', $asset->name);
        $this->assertEquals($file->getMimeType(), $asset->type);
        $this->assertEquals($file->getSize(), $asset->size);
        $this->assertEquals('assets/' . $file->hashName(), $asset->path);
    }
}
