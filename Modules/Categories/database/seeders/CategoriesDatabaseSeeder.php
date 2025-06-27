<?php

namespace Modules\Categories\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Categories\Models\Category;

class CategoriesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = $this->categories();

        Category::query()->delete();

        foreach ($categories as $category) {
            Category::factory()->create([
                "title" => $category["title"],
                "description" => $category["title"],
                "is_main" => true,
            ]);
        }
    }

    private function categories(): array
    {
        return [
            [
                "title" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
            ],
            [
                "title" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
            ],
            [
                "title" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
            ],
            [
                "title" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
            ],
            [
                "title" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
            ],
            [
                "title" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
            ],
        ];
    }
}
