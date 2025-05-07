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
        Schema::create("wallets", function (Blueprint $table) {
            $table->uid();
            $table
                ->foreignUlid("user_id")
                ->unique()
                ->constrained()
                ->noActionOnDelete();
            $table->json("balance");
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
        Schema::dropIfExists("wallets");
    }
};
