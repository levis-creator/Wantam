<?php

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Brand::class)->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('main_image');
            $table->json('images')->nullable();
            $table->longText('description')->nullable();

            // Price-related fields
            $table->decimal('original_price', 10, 2)->nullable();
            $table->decimal('discount', 5, 2)->nullable(); // Percentage: e.g. 20.00 means 20%
            $table->decimal('price', 10, 2); // final price after discount

            $table->integer('stock_quantity')->default(0);

            // Product status
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_featured')->default(false)->index();

            // Ratings (optional)
            $table->decimal('rating', 2, 1)->nullable(); // e.g. 4.5 out of 5

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
