<?php

namespace Tests\Browser\Admin;


use App\Models\Asset;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AssetDuskTest extends AdminDuskTestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     * @throws \Throwable
     */
    public function testIndexWithOtherModel()
    {
        factory(Asset::class)->create([
            'model' => 'Foo'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/assets')
                ->assertMissing('img[src*="download"]');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testIndexWithPaginator()
    {
        factory(Asset::class, 20)->create();

        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/assets')
                ->assertTitleContains('Assets')
                ->assertSeeLink('2');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testUploadAsset()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/assets')
                ->clickLink('Create Asset')
                ->assertPathIs('/admin/assets/create')
                ->assertTitleContains('Create Asset')
                ->attach('file', dirname(__DIR__) . '/avatar.jpeg')
                ->click('@upload')
                ->assertPathIs('/admin/assets')
                ->assertSee('The asset has been saved.')
                ->assertPresent('img[src*="download"]');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testUpload0Bytes()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/assets/create')
                ->attach('file', dirname(__DIR__) . '/0bytes.txt')
                ->click('@upload')
                ->assertSee('The asset has been saved.');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testUploadNoAsset()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/assets/create')
                ->click('@upload')
                ->assertPathIs('/admin/assets/create')
                ->assertSee('The file field is required.');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testView()
    {
        $asset = factory(Asset::class)->create();

        $this->browse(function (Browser $browser) use ($asset) {
            $browser->visit('/admin/assets')
                ->clickLink('View')
                ->assertPathIs('/admin/assets/' . $asset->id)
                ->assertTitleContains('View Asset')
                ->assertSee($asset->id)
                ->assertSee($asset->name)
                ->assertSee($asset->type)
                ->assertSee($asset->size)
                ->assertPresent('img[src*="download"]');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testUpdateAsset()
    {
        $asset = factory(Asset::class)->create();

        $this->browse(function (Browser $browser) use ($asset) {
            $browser->visit('/admin/assets')
                ->clickLink('Edit')
                ->assertTitleContains('Edit Asset')
                ->assertPathIs('/admin/assets/' . $asset->id . '/edit')
                ->attach('file', dirname(__DIR__) . '/avatar.jpeg')
                ->click('@upload')
                ->assertPathIs('/admin/assets')
                ->assertSee('The asset has been saved.')
                ->assertPresent('img[src*="download"]');
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testDestroyAsset()
    {
        factory(Asset::class)->create();

        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/assets')
                ->assertSee('Delete')
                ->click('@delete')
                ->assertPathIs('/admin/assets')
                ->assertSee('The asset has been deleted.');
        });
    }
}
