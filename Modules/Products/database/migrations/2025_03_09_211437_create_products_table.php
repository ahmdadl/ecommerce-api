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
        Schema::create("products", function (Blueprint $table) {
            $table->uid();
            $table->foreignUlid("category_id")->constrained();
            $table->foreignUlid('brand_id')->constrained();
            $table->json("title");
            $table->json("description")->nullable();
            $table->string("slug")->nullable();
            $table->boolean("is_main")->default(false);
            $table->json("images")->nullable();
            $table->decimal("price", 10, 2);
            $table->decimal("salePrice", 10, 2)->nullable();
            $table->integer('stock');
            $table->string('sku')->nullable();
            $table->activeState();
            $table->metaTags();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("products");
    }
};
