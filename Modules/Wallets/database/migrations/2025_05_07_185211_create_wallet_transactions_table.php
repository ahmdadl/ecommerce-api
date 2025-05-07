<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Wallets\Enums\WalletStatus;
use Modules\Wallets\Enums\WalletType;

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
                ->default(WalletStatus::PENDING->value)
                ->index();
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
