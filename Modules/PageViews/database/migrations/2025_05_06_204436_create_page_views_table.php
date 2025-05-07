<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("page_views", function (Blueprint $table) {
            $table->uid();
            $table->ulidMorphs("viewable"); // product, category, brand, tag
            $table->ulidMorphs("viewerable"); // user, guest
            $table->json("agent");
            $table->string("ip_address")->nullable();
            $table->string("page")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("page_views");
    }
};
