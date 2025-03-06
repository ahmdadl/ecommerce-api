<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Users\Models\User;

class UsersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->admin()->male()->create([
            'name' => 'Ahmed Adel',
            'email' => 'ahmdadl.dev@gmail.com',
            'password' => Hash::make('123123123'),
        ]);

        User::factory()->admin()->male()->create([
            'name' => 'Ahmed Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123123123'),
        ]);
    }
}
