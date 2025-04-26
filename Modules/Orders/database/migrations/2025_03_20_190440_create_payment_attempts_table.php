<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Orders\Enums\OrderPaymentStatus;
use Modules\Payments\Models\PaymentMethod;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("payment_attempts", function (Blueprint $table) {
            $table->uid();
            $table->foreignUlid("order_id")->constrained();
            $table->string("payment_method", 30);
            $table
                ->enum("status", OrderPaymentStatus::values())
                ->default(OrderPaymentStatus::PENDING->value);
            $table->string("receipt")->nullable();
            $table->json("payment_details")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("payment_attempts");
    }
};
