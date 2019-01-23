<?php

use App\Admin;
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Admin::class)->create();
    }
}
