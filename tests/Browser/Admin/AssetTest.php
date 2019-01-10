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
                ->assertTitle('Assets')
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
                ->assertTitle('Create Asset')
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
    public function testView()
    {
        $asset = factory(Asset::class)->create();

        $this->browse(function (Browser $browser) use ($asset) {
            $browser->visit('/admin/assets')
                ->clickLink('View')
                ->assertPathIs('/admin/assets/' . $asset->id)
                ->assertTitle('View Asset')
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
                ->assertTitle('Edit Asset')
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
