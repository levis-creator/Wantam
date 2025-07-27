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

            // Foreign keys
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Brand::class)->constrained()->cascadeOnDelete();

            // Product details
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('main_image'); // thumbnail / cover image
            $table->json('images')->nullable(); // gallery images
            $table->longText('description')->nullable();

            // Pricing
            $table->decimal('original_price', 10, 2)->nullable();
            $table->decimal('discount', 5, 2)->nullable(); // percentage (e.g. 15.00 = 15%)
            $table->decimal('price', 10, 2)->default(0);
            // Stock & status
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_featured')->default(false)->index();

            // Ratings (optional)
            $table->decimal('rating', 2, 1)->nullable(); // average rating: e.g. 4.5

            // Soft deletes and timestamps
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
