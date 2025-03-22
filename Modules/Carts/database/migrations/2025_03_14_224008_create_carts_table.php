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
        Schema::create("carts", function (Blueprint $table) {
            $table->uid();
            $table->morphs("cartable");
            $table->foreignUlid("address_id")->nullable()->constrained();
            $table->foreignUlid("coupon_id")->nullable()->constrained();
            $table->json("totals")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("carts");
    }
};
