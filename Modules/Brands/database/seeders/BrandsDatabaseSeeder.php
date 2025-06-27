<?php

namespace Modules\Brands\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Brands\Models\Brand;

class BrandsDatabaseSeeder extends Seeder
{
    public function run()
    {
        $brands = $this->brands();

        Brand::query()->delete();

        foreach ($brands as $brand) {
            Brand::factory()->create([
                "title" => $brand["title"],
                "description" => $brand["title"],
                "is_main" => true,
            ]);
        }
    }

    private function brands(): array
    {
        return [
            [
                "title" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
            ],
            [
                "title" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
            ],
            [
                "title" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
            ],
            [
                "title" => [
                    "en" => "Honor",
                    "ar" => "هونر",
                ],
            ],
            [
                "title" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
            ],
            [
                "title" => [
                    "en" => "Motorola",
                    "ar" => "موتورولا",
                ],
            ],
            [
                "title" => [
                    "en" => "Tecno",
                    "ar" => "تكنو",
                ],
            ],
        ];
    }
}
