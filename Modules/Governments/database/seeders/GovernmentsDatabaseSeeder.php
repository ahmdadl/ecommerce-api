<?php

namespace Modules\Governments\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Governments\Models\Government;

class GovernmentsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $governments = [
            [
                "en" => "Alexandria",
                "ar" => "الإسكندرية",
            ],
            [
                "en" => "Aswan",
                "ar" => "أسوان",
            ],
            [
                "en" => "Asyut",
                "ar" => "أسيوط",
            ],
            [
                "en" => "Beheira",
                "ar" => "البحيرة",
            ],
            [
                "en" => "Beni Suef",
                "ar" => "بني سويف",
            ],
            [
                "en" => "Cairo",
                "ar" => "القاهرة",
            ],
            [
                "en" => "Dakahlia",
                "ar" => "الدقهلية",
            ],
            [
                "en" => "Damietta",
                "ar" => "دمياط",
            ],
            [
                "en" => "Faiyum",
                "ar" => "الفيوم",
            ],
            [
                "en" => "Gharbia",
                "ar" => "الغربية",
            ],
            [
                "en" => "Giza",
                "ar" => "الجيزة",
            ],
            [
                "en" => "Ismailia",
                "ar" => "الإسماعيلية",
            ],
            [
                "en" => "Kafr El Sheikh",
                "ar" => "كفر الشيخ",
            ],
            [
                "en" => "Luxor",
                "ar" => "الأقصر",
            ],
            [
                "en" => "Matruh",
                "ar" => "مطروح",
            ],
            [
                "en" => "Minya",
                "ar" => "المنيا",
            ],
            [
                "en" => "Monufia",
                "ar" => "المنوفية",
            ],
            [
                "en" => "New Valley",
                "ar" => "الوادي الجديد",
            ],
            [
                "en" => "North Sinai",
                "ar" => "شمال سيناء",
            ],
            [
                "en" => "Port Said",
                "ar" => "بورسعيد",
            ],
            [
                "en" => "Qalyubia",
                "ar" => "القليوبية",
            ],
            [
                "en" => "Qena",
                "ar" => "قنا",
            ],
            [
                "en" => "Red Sea",
                "ar" => "البحر الأحمر",
            ],
            [
                "en" => "Sharqia",
                "ar" => "الشرقية",
            ],
            [
                "en" => "Sohag",
                "ar" => "سوهاج",
            ],
            [
                "en" => "South Sinai",
                "ar" => "جنوب سيناء",
            ],
            [
                "en" => "Suez",
                "ar" => "السويس",
            ],
        ];

        Government::query()->delete();

        foreach ($governments as $government) {
            Government::create([
                "title" => $government,
                "shipping_fees" => 0,
                "is_active" => true,
            ]);
        }
    }
}
