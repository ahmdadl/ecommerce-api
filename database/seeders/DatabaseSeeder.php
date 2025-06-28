<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Banners\Database\Seeders\BannersDatabaseSeeder;
use Modules\Cities\Database\Seeders\CitiesDatabaseSeeder;
use Modules\Cities\Filament\Clusters\Cities;
use Modules\Faqs\Database\Seeders\FaqSeeder;
use Modules\Governments\Database\Seeders\GovernmentsDatabaseSeeder;
use Modules\PageMetas\Database\Seeders\PageMetaSeeder;
use Modules\PrivacyPolicies\Database\Seeders\PrivacyPolicySeeder;
use Modules\Products\Database\Seeders\ProductsDatabaseSeeder;
use Modules\Products\Models\Product;
use Modules\Tags\Database\Seeders\TagsDatabaseSeeder;
use Modules\Terms\Database\Seeders\TermsDatabaseSeeder;
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
        (new PageMetaSeeder())->run();

        // ! dev only seeders
        (new ProductsDatabaseSeeder())->run();
        (new TagsDatabaseSeeder())->run();
        (new BannersDatabaseSeeder())->run();
        (new PrivacyPolicySeeder())->run();
        (new FaqSeeder())->run();
        (new TermsDatabaseSeeder())->run();
    }
}
