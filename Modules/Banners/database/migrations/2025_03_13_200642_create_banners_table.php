<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Banners\Enums\BannerActionType;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("banners", function (Blueprint $table) {
            $table->uid();
            $table->json("title");
            $table->json("subtitle")->nullable();
            $table->string("media", 255);
            $table->enum("action", BannerActionType::values())->nullable();
            $table->nullableUlidMorphs("actionable");
            $table->sortOrder();
            $table->activeState();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("banners");
    }
};
