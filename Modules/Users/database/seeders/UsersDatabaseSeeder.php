<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Users\Database\Factories\UserFactory;

class UsersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserFactory::new()->admin()->male()->create([
            'name' => 'Ahmed Adel',
            'email' => 'ahmdadl.dev@gmail.com',
        ]);
    }
}
