<?php

namespace Tests\Browser\Admin;


use App\Asset;
use Faker\Provider\File;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AssetTest extends DuskTestCase
{
    use DatabaseMigrations;

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
                ->attach('file', dirname(__DIR__) . '/avatar.jpeg')
                ->click('@upload')
                ->assertPathIs('/admin/assets')
                ->assertSee('The asset has been saved.');
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
