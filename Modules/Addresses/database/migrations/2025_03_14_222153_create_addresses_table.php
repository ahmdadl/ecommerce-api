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
            $table->string("firstName", 50);
            $table->string("lastName", 50);
            $table->string("title", 100)->nullable();
            $table->string("address", 250);
            $table->string("phoneNumber", 15);
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
