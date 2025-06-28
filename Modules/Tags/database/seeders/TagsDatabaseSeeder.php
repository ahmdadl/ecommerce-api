<?php

namespace Modules\Tags\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Products\Models\Product;
use Modules\Tags\Models\Tag;

class TagsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::query()->delete();

        $tagsData = $this->tagsData();
        foreach ($tagsData as $tagData) {
            /** @var Tag $tag */
            $tag = Tag::create($tagData);

            $tag->products()->sync(
                Product::inRandomOrder()
                    ->limit(random_int(3, 12))
                    ->get()
                    ->pluck("id")
            );
        }

        dump(Tag::count() . " tags seeded successfully");
    }

    private function tagsData(): array
    {
        return [
            [
                "title" => [
                    "en" => "Tech",
                    "ar" => "تكنولوجيا",
                ],
                "description" => [
                    "en" =>
                        "Cutting-edge technology products including smartphones, tablets, and smart watches.",
                    "ar" =>
                        "منتجات تكنولوجية متطورة تشمل الهواتف الذكية والأجهزة اللوحية والساعات الذكية.",
                ],
            ],
            [
                "title" => [
                    "en" => "Gadgets",
                    "ar" => "أجهزة",
                ],
                "description" => [
                    "en" =>
                        "Innovative gadgets for everyday use, from portable audio to smart devices.",
                    "ar" =>
                        "أجهزة مبتكرة للاستخدام اليومي، من الصوتيات المحمولة إلى الأجهزة الذكية.",
                ],
            ],
            [
                "title" => [
                    "en" => "Electronics",
                    "ar" => "إلكترونيات",
                ],
                "description" => [
                    "en" =>
                        "High-quality electronic devices and accessories for modern lifestyles.",
                    "ar" =>
                        "أجهزة وإكسسوارات إلكترونية عالية الجودة لأنماط الحياة العصرية.",
                ],
            ],
            [
                "title" => [
                    "en" => "Mobile Devices",
                    "ar" => "أجهزة محمولة",
                ],
                "description" => [
                    "en" =>
                        "Smartphones and tablets designed for performance and connectivity.",
                    "ar" => "هواتف ذكية وأجهزة لوحية مصممة للأداء والتواصل.",
                ],
            ],
            [
                "title" => [
                    "en" => "Accessories",
                    "ar" => "إكسسوارات",
                ],
                "description" => [
                    "en" =>
                        "Essential mobile and tablet accessories to enhance your device experience.",
                    "ar" =>
                        "إكسسوارات أساسية للهواتف والأجهزة اللوحية لتحسين تجربة الجهاز.",
                ],
            ],
        ];
    }
}
