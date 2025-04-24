<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Cities\Database\Seeders\CitiesDatabaseSeeder;
use Modules\Cities\Filament\Clusters\Cities;
use Modules\Governments\Database\Seeders\GovernmentsDatabaseSeeder;
use Modules\PageMetas\Database\Seeders\PageMetaSeeder;
use Modules\Products\Database\Seeders\ProductsDatabaseSeeder;
use Modules\Products\Models\Product;
use Modules\Users\Database\Seeders\UsersDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        (new UsersDatabaseSeeder())->run();
        (new GovernmentsDatabaseSeeder())->run();
        (new CitiesDatabaseSeeder())->run();
        (new ProductsDatabaseSeeder())->run();
        (new PageMetaSeeder())->run();
    }
}
