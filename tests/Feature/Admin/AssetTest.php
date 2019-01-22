<?php

namespace Tests\Feature\Admin;

use App\Asset;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AssetTest extends AdminTestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testIndex()
    {
        $this->get('/admin/assets')
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $this->get('/admin/assets/create')
            ->assertOk();
    }

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
    public function testShow()
    {
        Storage::fake();

        $asset = factory(Asset::class)->create();

        $this->get('/admin/assets/' . $asset->id)
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testShowWithMissing()
    {
        $this->get('/admin/assets/0')
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testEdit()
    {
        Storage::fake();

        $asset = factory(Asset::class)->create();

        $this->get('/admin/assets/' . $asset->id . '/edit')
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testEditWithMissing()
    {
        $this->get('/admin/assets/0/edit')
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testUpdateWithMissing()
    {
        Storage::fake();

        $file = UploadedFile::fake()->image('avatar.jpg');

        $this->put('/admin/assets/0', [
            'file' => $file
        ])
            ->assertNotFound();
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        Storage::fake();

        $asset = factory(Asset::class)->create();

        $file = UploadedFile::fake()->image('logo.png');

        $this->put('/admin/assets/' . $asset->id, [
            'file' => $file
        ]);

        $updated = Asset::query()->find($asset->id);

        $this->assertEquals('Asset', $updated->model);
        $this->assertEquals(null, $updated->foeign_key);
        $this->assertEquals('logo.png', $updated->name);
        $this->assertEquals($file->getMimeType(), $updated->type);
        $this->assertEquals($file->getSize(), $updated->size);
        $this->assertEquals('assets/' . $file->hashName(), $updated->path);
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
            ->assertRedirect();

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
