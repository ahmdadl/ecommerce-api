<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Orders\Enums\OrderPaymentStatus;
use Modules\Orders\Enums\OrderStatus;
use Modules\Payments\Models\PaymentMethod;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("orders", function (Blueprint $table) {
            $table->uid();
            $table->foreignUlid("user_id")->constrained();
            $table
                ->foreignUlid("coupon_id")
                ->nullable()
                ->constrained("order_coupons");
            $table->foreignUlid("address_id")->constrained("order_addresses");
            $table->json("totals")->nullable();
            $table->enum(
                "paymentMethod",
                PaymentMethod::all()->pluck("code")->toArray()
            );
            $table
                ->enum("status", OrderStatus::values())
                ->default(OrderStatus::PENDING->value);
            $table
                ->enum("paymentStatus", OrderPaymentStatus::values())
                ->default(OrderPaymentStatus::PENDING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("orders");
    }
};
