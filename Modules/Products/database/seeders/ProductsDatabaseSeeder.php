<?php

namespace Modules\Products\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Brands\Database\Seeders\BrandsDatabaseSeeder;
use Modules\Brands\Models\Brand;
use Modules\Categories\Database\Seeders\CategoriesDatabaseSeeder;
use Modules\Categories\Models\Category;
use Modules\Products\Models\Product;

class ProductsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create categories
        DB::transaction(function () {
            (new CategoriesDatabaseSeeder())->run();
            (new BrandsDatabaseSeeder())->run();

            $categories = Category::all();
            $brands = Brand::all();

            Product::query()->delete();

            $products = $this->rawProducts();

            foreach ($products as $data) {
                $category = $categories
                    ->where("title", $data["category"]["en"])
                    ->first();
                $brand = $brands->where("title", $data["brand"]["en"])->first();

                Product::factory()->create([
                    "category_id" => $category->id,
                    "brand_id" => $brand->id,
                    "title" => $data["product"],
                ]);
            }
        });

        dump(Product::count());
    }

    private function rawProducts(): array
    {
        return [
            // Smartphones
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "iPhone 16 Pro",
                    "ar" => "آيفون 16 برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "iPhone 16",
                    "ar" => "آيفون 16",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy S25 Ultra",
                    "ar" => "جالاكسي إس 25 ألترا",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy A56",
                    "ar" => "جالاكسي إيه 56",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "Mate 60 Pro",
                    "ar" => "ميت 60 برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "Pura 70",
                    "ar" => "بورا 70",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Honor",
                    "ar" => "هونر",
                ],
                "product" => [
                    "en" => "Magic 6 Pro",
                    "ar" => "ماجيك 6 برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Honor",
                    "ar" => "هونر",
                ],
                "product" => [
                    "en" => "X7c",
                    "ar" => "إكس 7 سي",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Xiaomi 15 Ultra",
                    "ar" => "شاومي 15 ألترا",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Redmi Note 13",
                    "ar" => "ريدي نوت 13",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Motorola",
                    "ar" => "موتورولا",
                ],
                "product" => [
                    "en" => "Edge 50 Neo",
                    "ar" => "إيدج 50 نيو",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Motorola",
                    "ar" => "موتورولا",
                ],
                "product" => [
                    "en" => "Moto G15",
                    "ar" => "موتو جي 15",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Tecno",
                    "ar" => "تكنو",
                ],
                "product" => [
                    "en" => "Camon 40",
                    "ar" => "كامون 40",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Tecno",
                    "ar" => "تكنو",
                ],
                "product" => [
                    "en" => "Spark 20",
                    "ar" => "سبارك 20",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Z Fold 6",
                    "ar" => "جالاكسي زد فولد 6",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "iPhone 15 Pro Max",
                    "ar" => "آيفون 15 برو ماكس",
                ],
            ],
            // Tablets
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "iPad Pro 13-inch",
                    "ar" => "آيباد برو 13 بوصة",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "iPad Air 11-inch",
                    "ar" => "آيباد إير 11 بوصة",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Tab S9 Ultra",
                    "ar" => "جالاكسي تاب إس 9 ألترا",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Tab A8",
                    "ar" => "جالاكسي تاب إيه 8",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "MatePad Pro 12.6",
                    "ar" => "ميت باد برو 12.6",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "MatePad 11",
                    "ar" => "ميت باد 11",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Pad 6",
                    "ar" => "باد 6",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Redmi Pad SE",
                    "ar" => "ريدي باد إس إي",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Honor",
                    "ar" => "هونر",
                ],
                "product" => [
                    "en" => "Pad 9",
                    "ar" => "باد 9",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Honor",
                    "ar" => "هونر",
                ],
                "product" => [
                    "en" => "Pad X9",
                    "ar" => "باد إكس 9",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Tecno",
                    "ar" => "تكنو",
                ],
                "product" => [
                    "en" => "Phantom Pad",
                    "ar" => "فانتوم باد",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Motorola",
                    "ar" => "موتورولا",
                ],
                "product" => [
                    "en" => "Moto Tab G70",
                    "ar" => "موتو تاب جي 70",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Tab S6 Lite",
                    "ar" => "جالاكسي تاب إس 6 لايت",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "iPad 10th Gen",
                    "ar" => "آيباد الجيل العاشر",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Pad 5",
                    "ar" => "باد 5",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Tab A9",
                    "ar" => "جالاكسي تاب إيه 9",
                ],
            ],
            // Smart Watches
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "Apple Watch Series 10",
                    "ar" => "آبل ووتش سيريز 10",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "Apple Watch Ultra 2",
                    "ar" => "آبل ووتش ألترا 2",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Watch 6 Classic",
                    "ar" => "جالاكسي ووتش 6 كلاسيك",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Watch 7",
                    "ar" => "جالاكسي ووتش 7",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "Watch GT 5",
                    "ar" => "ووتش جي تي 5",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "Band 9",
                    "ar" => "باند 9",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Honor",
                    "ar" => "هونر",
                ],
                "product" => [
                    "en" => "Watch GS 4",
                    "ar" => "ووتش جي إس 4",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Honor",
                    "ar" => "هونر",
                ],
                "product" => [
                    "en" => "Choice Watch",
                    "ar" => "تشويس ووتش",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Watch S3",
                    "ar" => "ووتش إس 3",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Redmi Watch 4",
                    "ar" => "ريدي ووتش 4",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Motorola",
                    "ar" => "موتورولا",
                ],
                "product" => [
                    "en" => "Moto Watch 100",
                    "ar" => "موتو ووتش 100",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Tecno",
                    "ar" => "تكنو",
                ],
                "product" => [
                    "en" => "Watch Pro 2",
                    "ar" => "ووتش برو 2",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Watch 6",
                    "ar" => "جالاكسي ووتش 6",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "Apple Watch SE 2",
                    "ar" => "آبل ووتش إس إي 2",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "Watch Fit 3",
                    "ar" => "ووتش فيت 3",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Smart Band 9",
                    "ar" => "سمارت باند 9",
                ],
            ],
            // Portable Audio
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "AirPods Pro 2",
                    "ar" => "إيربودز برو 2",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "AirPods 4",
                    "ar" => "إيربودز 4",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Buds 3 Pro",
                    "ar" => "جالاكسي بودز 3 برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Buds 3",
                    "ar" => "جالاكسي بودز 3",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "FreeBuds Pro 3",
                    "ar" => "فري بودز برو 3",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "FreeClip",
                    "ar" => "فري كليب",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Honor",
                    "ar" => "هونر",
                ],
                "product" => [
                    "en" => "Earbuds X6",
                    "ar" => "إيربودز إكس 6",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Honor",
                    "ar" => "هونر",
                ],
                "product" => [
                    "en" => "Choice Earbuds",
                    "ar" => "تشويس إيربودز",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Redmi Buds 5 Pro",
                    "ar" => "ريدي بودز 5 برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Buds 4 Active",
                    "ar" => "بودز 4 أكتيف",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Tecno",
                    "ar" => "تكنو",
                ],
                "product" => [
                    "en" => "Sonic 1",
                    "ar" => "سونيك 1",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Tecno",
                    "ar" => "تكنو",
                ],
                "product" => [
                    "en" => "True 1",
                    "ar" => "ترو 1",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Motorola",
                    "ar" => "موتورولا",
                ],
                "product" => [
                    "en" => "Moto Buds 600",
                    "ar" => "موتو بودز 600",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Buds 2 Pro",
                    "ar" => "جالاكسي بودز 2 برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "AirPods Max",
                    "ar" => "إيربودز ماكس",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "FreeBuds 5i",
                    "ar" => "فري بودز 5 آي",
                ],
            ],
            // Mobile Accessories
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "MagSafe Charger",
                    "ar" => "شاحن ماج سيف",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "iPhone 16 Silicone Case",
                    "ar" => "جراب آيفون 16 سيليكون",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy S24 Ultra Clear Case",
                    "ar" => "جراب جالاكسي إس 24 ألترا شفاف",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Wireless Charger Duo",
                    "ar" => "شاحن لاسلكي ديو",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "SuperCharge Adapter",
                    "ar" => "شاحن سوبر تشارج",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "Mate 60 Pro Case",
                    "ar" => "جراب ميت 60 برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Honor",
                    "ar" => "هونر",
                ],
                "product" => [
                    "en" => "Magic 6 Pro Screen Protector",
                    "ar" => "واقي شاشة ماجيك 6 برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Honor",
                    "ar" => "هونر",
                ],
                "product" => [
                    "en" => "X7c Clear Case",
                    "ar" => "جراب إكس 7 سي شفاف",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Redmi Note 13 Case",
                    "ar" => "جراب ريدي نوت 13",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "67W Turbo Charger",
                    "ar" => "شاحن تيربو 67 واط",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Motorola",
                    "ar" => "موتورولا",
                ],
                "product" => [
                    "en" => "Edge 50 Neo Screen Protector",
                    "ar" => "واقي شاشة إيدج 50 نيو",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Motorola",
                    "ar" => "موتورولا",
                ],
                "product" => [
                    "en" => "Moto G15 Case",
                    "ar" => "جراب موتو جي 15",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Tecno",
                    "ar" => "تكنو",
                ],
                "product" => [
                    "en" => "Camon 40 Charger",
                    "ar" => "شاحن كامون 40",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Tecno",
                    "ar" => "تكنو",
                ],
                "product" => [
                    "en" => "Spark 20 Case",
                    "ar" => "جراب سبارك 20",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Z Fold 6 Case",
                    "ar" => "جراب جالاكسي زد فولد 6",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "Lightning Cable",
                    "ar" => "كابل لايتنينج",
                ],
            ],
            // Tablet Accessories
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "Apple Pencil Pro",
                    "ar" => "قلم آبل برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "iPad Pro Smart Folio",
                    "ar" => "جراب آيباد برو سمارت فوليو",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Tab S9 Keyboard Cover",
                    "ar" => "غطاء لوحة مفاتيح جالاكسي تاب إس 9",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Tab A8 Screen Protector",
                    "ar" => "واقي شاشة جالاكسي تاب إيه 8",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "MatePad Pro Smart Cover",
                    "ar" => "غطاء ميت باد برو الذكي",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "M-Pencil 2",
                    "ar" => "إم-بنسل 2",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Pad 6 Keyboard",
                    "ar" => "لوحة مفاتيح باد 6",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Redmi Pad SE Case",
                    "ar" => "جراب ريدي باد إس إي",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Honor",
                    "ar" => "هونر",
                ],
                "product" => [
                    "en" => "Pad 9 Screen Protector",
                    "ar" => "واقي شاشة باد 9",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Honor",
                    "ar" => "هونر",
                ],
                "product" => [
                    "en" => "Pad X9 Smart Cover",
                    "ar" => "غطاء باد إكس 9 الذكي",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Tecno",
                    "ar" => "تكنو",
                ],
                "product" => [
                    "en" => "Phantom Pad Case",
                    "ar" => "جراب فانتوم باد",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Motorola",
                    "ar" => "موتورولا",
                ],
                "product" => [
                    "en" => "Moto Tab G70 Folio Case",
                    "ar" => "جراب موتو تاب جي 70 فوليو",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Tab S9 Ultra Case",
                    "ar" => "جراب جالاكسي تاب إس 9 ألترا",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "iPad 10th Gen Keyboard",
                    "ar" => "لوحة مفاتيح آيباد الجيل العاشر",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Pad 5 Stylus",
                    "ar" => "قلم باد 5",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "S Pen for Galaxy Tab S9",
                    "ar" => "قلم إس بن لجالاكسي تاب إس 9",
                ],
            ],
            // Smartphones (5 additional products)
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "iPhone 15",
                    "ar" => "آيفون 15",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Z Flip 6",
                    "ar" => "جالاكسي زد فليب 6",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "Nova 12 Pro",
                    "ar" => "نوفا 12 برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Poco F6",
                    "ar" => "بوكو إف 6",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Tecno",
                    "ar" => "تكنو",
                ],
                "product" => [
                    "en" => "Pova 6 Neo",
                    "ar" => "بوفا 6 نيو",
                ],
            ],
            // Tablets (4 additional products)
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "iPad Mini 7",
                    "ar" => "آيباد ميني 7",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Tab S8",
                    "ar" => "جالاكسي تاب إس 8",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "MatePad SE",
                    "ar" => "ميت باد إس إي",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Pad 6S Pro",
                    "ar" => "باد 6 إس برو",
                ],
            ],
            // Smart Watches (3 additional products)
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "Apple Watch Series 9",
                    "ar" => "آبل ووتش سيريز 9",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Watch 5 Pro",
                    "ar" => "جالاكسي ووتش 5 برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "Watch GT 4",
                    "ar" => "ووتش جي تي 4",
                ],
            ],
            // Portable Audio (4 additional products)
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "AirPods 3",
                    "ar" => "إيربودز 3",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Buds FE",
                    "ar" => "جالاكسي بودز إف إي",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "FreeBuds SE 2",
                    "ar" => "فري بودز إس إي 2",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Redmi Buds 4 Lite",
                    "ar" => "ريدي بودز 4 لايت",
                ],
            ],
            // Mobile Accessories (6 additional products)
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "iPhone 15 Pro Case",
                    "ar" => "جراب آيفون 15 برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy S24 Screen Protector",
                    "ar" => "واقي شاشة جالاكسي إس 24",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "Pura 70 Screen Protector",
                    "ar" => "واقي شاشة بورا 70",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Poco F6 Charger",
                    "ar" => "شاحن بوكو إف 6",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Honor",
                    "ar" => "هونر",
                ],
                "product" => [
                    "en" => "Magic 6 Pro Charger",
                    "ar" => "شاحن ماجيك 6 برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Tecno",
                    "ar" => "تكنو",
                ],
                "product" => [
                    "en" => "Pova 6 Neo Screen Protector",
                    "ar" => "واقي شاشة بوفا 6 نيو",
                ],
            ],
            // Tablet Accessories (5 additional products)
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "iPad Air Smart Cover",
                    "ar" => "غطاء آيباد إير الذكي",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Tab S8 Case",
                    "ar" => "جراب جالاكسي تاب إس 8",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "MatePad SE Screen Protector",
                    "ar" => "واقي شاشة ميت باد إس إي",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Pad 6S Pro Case",
                    "ar" => "جراب باد 6 إس برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Honor",
                    "ar" => "هونر",
                ],
                "product" => [
                    "en" => "Pad 9 Keyboard",
                    "ar" => "لوحة مفاتيح باد",
                ],
            ],
            // Smartphones (5 additional products)
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "iPhone 15",
                    "ar" => "آيفون 15",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Z Flip 6",
                    "ar" => "جالاكسي زد فليب 6",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "Nova 12 Pro",
                    "ar" => "نوفا 12 برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Poco F6",
                    "ar" => "بوكو إف 6",
                ],
            ],
            [
                "category" => [
                    "en" => "Smartphones",
                    "ar" => "الهواتف الذكية",
                ],
                "brand" => [
                    "en" => "Tecno",
                    "ar" => "تكنو",
                ],
                "product" => [
                    "en" => "Pova 6 Neo",
                    "ar" => "بوفا 6 نيو",
                ],
            ],
            // Tablets (4 additional products)
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "iPad Mini 7",
                    "ar" => "آيباد ميني 7",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Tab S8",
                    "ar" => "جالاكسي تاب إس 8",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "MatePad SE",
                    "ar" => "ميت باد إس إي",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablets",
                    "ar" => "الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Pad 6S Pro",
                    "ar" => "باد 6 إس برو",
                ],
            ],
            // Smart Watches (3 additional products)
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "Apple Watch Series 9",
                    "ar" => "آبل ووتش سيريز 9",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Watch 5 Pro",
                    "ar" => "جالاكسي ووتش 5 برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Smart Watches",
                    "ar" => "الساعات الذكية",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "Watch GT 4",
                    "ar" => "ووتش جي تي 4",
                ],
            ],
            // Portable Audio (4 additional products)
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "AirPods 3",
                    "ar" => "إيربودز 3",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Buds FE",
                    "ar" => "جالاكسي بودز إف إي",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "FreeBuds SE 2",
                    "ar" => "فري بودز إس إي 2",
                ],
            ],
            [
                "category" => [
                    "en" => "Portable Audio",
                    "ar" => "الصوتيات المحمولة",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Redmi Buds 4 Lite",
                    "ar" => "ريدي بودز 4 لايت",
                ],
            ],
            // Mobile Accessories (6 additional products)
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "iPhone 15 Pro Case",
                    "ar" => "جراب آيفون 15 برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy S24 Screen Protector",
                    "ar" => "واقي شاشة جالاكسي إس 24",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "Pura 70 Screen Protector",
                    "ar" => "واقي شاشة بورا 70",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Poco F6 Charger",
                    "ar" => "شاحن بوكو إف 6",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Honor",
                    "ar" => "هونر",
                ],
                "product" => [
                    "en" => "Magic 6 Pro Charger",
                    "ar" => "شاحن ماجيك 6 برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Mobile Accessories",
                    "ar" => "إكسسوارات الهواتف",
                ],
                "brand" => [
                    "en" => "Tecno",
                    "ar" => "تكنو",
                ],
                "product" => [
                    "en" => "Pova 6 Neo Screen Protector",
                    "ar" => "واقي شاشة بوفا 6 نيو",
                ],
            ],
            // Tablet Accessories (5 additional products)
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Apple",
                    "ar" => "آبل",
                ],
                "product" => [
                    "en" => "iPad Air Smart Cover",
                    "ar" => "غطاء آيباد إير الذكي",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Samsung",
                    "ar" => "سامسونج",
                ],
                "product" => [
                    "en" => "Galaxy Tab S8 Case",
                    "ar" => "جراب جالاكسي تاب إس 8",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Huawei",
                    "ar" => "هواوي",
                ],
                "product" => [
                    "en" => "MatePad SE Screen Protector",
                    "ar" => "واقي شاشة ميت باد إس إي",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Xiaomi",
                    "ar" => "شاومي",
                ],
                "product" => [
                    "en" => "Pad 6S Pro Case",
                    "ar" => "جراب باد 6 إس برو",
                ],
            ],
            [
                "category" => [
                    "en" => "Tablet Accessories",
                    "ar" => "إكسسوارات الأجهزة اللوحية",
                ],
                "brand" => [
                    "en" => "Honor",
                    "ar" => "هونر",
                ],
                "product" => [
                    "en" => "Pad 9 Keyboard",
                    "ar" => "لوحة مفاتيح باد 9",
                ],
            ],
        ];
    }
}
