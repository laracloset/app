<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            User::ADMIN,
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
