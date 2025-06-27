<?php

namespace Modules\Banners\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Banners\Enums\BannerActionType;
use Modules\Banners\Models\Banner;
use Modules\Categories\Models\Category;

class BannersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::query()->delete();

        $banners = [
            [
                "title" => [
                    "en" => "Discover the Latest Smartphones",
                    "ar" => "اكتشف أحدث الهواتف الذكية",
                ],
                "subtitle" => [
                    "en" => "Explore cutting-edge technology and sleek designs",
                    "ar" => "استكشف التكنولوجيا المتطورة والتصاميم الأنيقة",
                ],
                "media" => "banner-1.png",
                "action" => BannerActionType::MEDIA,
            ],
            [
                "title" => [
                    "en" => "Unleash Your Mobile Experience",
                    "ar" => "أطلق العنان لتجربة هاتفك المحمول",
                ],
                "subtitle" => [
                    "en" => "Shop the best deals on smartphones today",
                    "ar" => "تسوق أفضل العروض على الهواتف الذكية اليوم",
                ],
                "media" => "banner-2.png",
                "action" => BannerActionType::CATEGORY,
                "actionable_id" => Category::where(
                    "slug",
                    "smartphones"
                )->first()->id,
                "actionable_type" => Category::class,
            ],
            [
                "title" => [
                    "en" => "Stay Connected with Top Brands",
                    "ar" => "ابقَ متصلاً مع أفضل العلامات التجارية",
                ],
                "subtitle" => [
                    "en" => "Find your perfect smartphone match",
                    "ar" => "اعثر على هاتفك الذكي المثالي",
                ],
                "media" => "banner-3.png",
                "action" => BannerActionType::MEDIA,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::factory()->create($banner);
        }
    }
}
