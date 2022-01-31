<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
