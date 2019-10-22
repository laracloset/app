<?php

use App\Admin;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        $admins = [
            [
                'email' => 'admin@example.com',
                'password' => Hash::make('secret')
            ]
        ];

        foreach ($admins as $admin) {
            factory(Admin::class)->create($admin);
        }
    }
}
