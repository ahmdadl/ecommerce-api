<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Orders\Enums\OrderPaymentStatus;
use Modules\Wallets\Enums\WalletTransactionStatus;
use Modules\Wallets\Enums\WalletTransactionType;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("wallet_transactions", function (Blueprint $table) {
            $table->uid();
            $table->foreignUlid("wallet_id")->constrained();
            $table
                ->foreignUlid("created_by")
                ->constrained("users")
                ->noActionOnDelete();
            $table->decimal("amount");
            $table->string("type")->index();
            $table
                ->string("status")
                ->default(WalletTransactionStatus::PENDING->value)
                ->index();
            $table
                ->string("payment_status")
                ->default(OrderPaymentStatus::PENDING->value);
            $table->string("payment_method")->nullable();
            $table->string("notes", 250)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("wallet_transactions");
    }
};
