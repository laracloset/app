<?php

namespace Tests\Browser\Admin;

use App\Asset;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AssetTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws \Throwable
     *
     * @return void
     */
    public function testIndexWithOtherModel()
    {
        factory(Asset::class)->create([
            'model' => 'Foo',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/assets')
                ->assertMissing('img[src*="download"]');
        });
    }

    /**
     * @throws \Throwable
     *
     * @return void
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
     * @throws \Throwable
     *
     * @return void
     */
    public function testUploadAsset()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/assets')
                ->clickLink('Create Asset')
                ->assertPathIs('/admin/assets/create')
                ->assertTitleContains('Create Asset')
                ->attach('file', dirname(__DIR__).'/avatar.jpeg')
                ->click('@upload')
                ->assertPathIs('/admin/assets')
                ->assertSee('The asset has been saved.')
                ->assertPresent('img[src*="download"]');
        });
    }

    /**
     * @throws \Throwable
     *
     * @return void
     */
    public function testUpload0Bytes()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/assets/create')
                ->attach('file', dirname(__DIR__).'/0bytes.txt')
                ->click('@upload')
                ->assertSee('The asset has been saved.');
        });
    }

    /**
     * @throws \Throwable
     *
     * @return void
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
     * @throws \Throwable
     *
     * @return void
     */
    public function testView()
    {
        $asset = factory(Asset::class)->create();

        $this->browse(function (Browser $browser) use ($asset) {
            $browser->visit('/admin/assets')
                ->clickLink('View')
                ->assertPathIs('/admin/assets/'.$asset->id)
                ->assertTitleContains('View Asset')
                ->assertSee($asset->id)
                ->assertSee($asset->name)
                ->assertSee($asset->type)
                ->assertSee($asset->size)
                ->assertPresent('img[src*="download"]');
        });
    }

    /**
     * @throws \Throwable
     *
     * @return void
     */
    public function testUpdateAsset()
    {
        $asset = factory(Asset::class)->create();

        $this->browse(function (Browser $browser) use ($asset) {
            $browser->visit('/admin/assets')
                ->clickLink('Edit')
                ->assertTitleContains('Edit Asset')
                ->assertPathIs('/admin/assets/'.$asset->id.'/edit')
                ->attach('file', dirname(__DIR__).'/avatar.jpeg')
                ->click('@upload')
                ->assertPathIs('/admin/assets')
                ->assertSee('The asset has been saved.')
                ->assertPresent('img[src*="download"]');
        });
    }

    /**
     * @throws \Throwable
     *
     * @return void
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
