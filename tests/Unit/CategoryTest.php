<?php

namespace Tests\Unit;


use App\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testSoftDelete()
    {
        $category = factory(Category::class)->create();
        $category->delete();

        $this->assertTrue($category->trashed());
    }
}
