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

    /**
     * @return void
     */
    public function testDestroyWithMissingAsset()
    {
        $this->delete('/admin/assets/0')
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testDestroy()
    {
        Storage::fake();

        $asset = factory(Asset::class)->create();

        $this->delete('/admin/assets/' . $asset->id)
            ->assertRedirect('/admin/assets');

        $this->assertNull(Asset::query()->find($asset->id));

        // Assert the file was deleted...
        Storage::disk()->assertMissing($asset->path);
    }

    /**
     * @return void
     */
    public function testDownloadWithMissingAsset()
    {
        $this->get('/admin/assets/0/download/')
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testDownload()
    {
        Storage::fake();

        $asset = factory(Asset::class)->create();

        $this->get('/admin/assets/' . $asset->id . '/download')
            ->assertHeader('Content-Type', $asset->type)
            ->assertOk();
    }
}
