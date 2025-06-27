<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("settings", function (Blueprint $table) {
            $table->id();
            $table->json("data")->nullable();
            $table->timestamps();
        });

        DB::table("settings")->insert([
            "data" => json_encode([
                "general" => [
                    "name" => [
                        "en" => "TechTrend Innovations",
                        "ar" => "تك تريند إنوفيشنز",
                    ],
                    "description" => [
                        "en" =>
                            "TechTrend Innovations offers a curated selection of smartphones, tablets, smart watches, portable audio, and mobile and tablet accessories, delivering cutting-edge technology to enhance your digital lifestyle.",
                        "ar" =>
                            "تك تريند إنوفيشنز يقدم مجموعة مختارة من الهواتف الذكية، الأجهزة اللوحية، الساعات الذكية، الصوت المحمول، وإكسسوارات الهواتف والأجهزة اللوحية، لتعزيز أسلوب حياتك الرقمي بتكنولوجيا متطورة.",
                    ],
                    "maintenance_mode" => false,
                ],
                "social" => [
                    "facebook" => "https://www.facebook.com",
                    "twitter" => "https://twitter.com",
                    "instagram" => "https://www.instagram.com",
                    "youtube" => "https://www.youtube.com",
                    "whatsapp" => "https://wa.me/20123456789",
                ],
                "contact" => [
                    "email" => "contact@techtrendinnovations.com",
                    "phoneNumbers" => ["+20123456789", "+20123456798"],
                    "address" => [
                        "en" => "123 Main St, Anytown, USA",
                        "ar" => "123 Main St, Anytown, USA",
                    ],
                    "googleMapUrl" => "https://www.google.com/maps",
                ],
                "top_header" => [
                    "body" => [
                        "en" =>
                            "Unlock the Future! Get 15% OFF Smartphones, Tablets, Smart Watches & More at TechTrend Innovations. Shop Now!",
                        "ar" =>
                            "اكتشف المستقبل! احصل على خصم 15% على الهواتف الذكية، الأجهزة اللوحية، الساعات الذكية والمزيد في تك تريند إنوفيشنز. تسوق الآن!",
                    ],
                    "image" => "",
                    "is_active" => true,
                    "end_time" => now()->addDays(25),
                ],
            ]),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("settings");
    }
};
