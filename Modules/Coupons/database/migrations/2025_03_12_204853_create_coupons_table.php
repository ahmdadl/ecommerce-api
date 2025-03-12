<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Coupons\Enums\CouponDiscountType;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("coupons", function (Blueprint $table) {
            $table->uid();
            $table->string("code", 50)->unique();
            $table->string("name")->nullable();
            $table->date("starts_at");
            $table->date("ends_at");
            $table
                ->enum("discount_type", CouponDiscountType::values())
                ->default(CouponDiscountType::PERCENTAGE->value);
            $table->float("value");
            $table->float("max_discount")->nullable();
            $table->unsignedInteger("used_count")->default(0);
            $table->activeState();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("coupons");
    }
};
