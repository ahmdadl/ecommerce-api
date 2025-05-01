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
        Schema::create("addresses", function (Blueprint $table) {
            $table->uid();
            $table->foreignUlid("user_id")->constrained();
            $table->foreignUlid("government_id")->constrained();
            $table->foreignUlid("city_id")->constrained();
            $table->string("first_name", 50);
            $table->string("last_name", 50);
            $table->string("title", 100)->nullable();
            $table->string("address", 250);
            $table->string("phone", 12);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("addresses");
    }
};
