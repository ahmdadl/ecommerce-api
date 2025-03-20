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
        Schema::create("order_coupons", function (Blueprint $table) {
            $table->uid();
            $table->foreignUlid("coupon_id")->constrained();
            $table->string("code", 50)->unique();
            $table->string("name")->nullable();
            $table
                ->enum("discount_type", CouponDiscountType::values())
                ->default(CouponDiscountType::PERCENTAGE->value);
            $table->float("value");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("order_coupons");
    }
};
