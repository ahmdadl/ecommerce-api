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
        Schema::create("contact_us_messages", function (Blueprint $table) {
            $table->uid();
            $table->string("name", 100);
            $table->string("email");
            $table->string("phone", 15)->nullable();
            $table->string("order_id", 50)->nullable();
            $table->string("subject", 150);
            $table->text("message");
            $table->boolean("is_seen")->default(false);
            $table->text("reply")->nullable();
            $table->timestamp("replied_at")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("contact_us_messages");
    }
};
