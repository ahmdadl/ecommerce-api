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
        Schema::create("privacy_policies", function (Blueprint $table) {
            $table->uid();
            $table->json("title");
            $table->json("content");
            $table->activeState();
            $table->sortOrder();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("privacy_policies");
    }
};
