<?php

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
            $table->id();

            // --- Basic Info ---
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->string('sku')->unique()->nullable();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('brand')->nullable();

            // --- Pricing ---
            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('regular_price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->enum('discount_type', ['percent', 'fixed'])->nullable();
            $table->decimal('discount_value', 10, 2)->default(0.00);
            $table->decimal('discounted_price', 10, 2)->nullable();
            $table->decimal('tax_rate', 5, 2)->default(0.00);

            // --- Inventory & Dimensions ---
            $table->integer('stock_quantity')->default(0);
            $table->boolean('is_in_stock')->default(true);
            $table->boolean('backorder_allowed')->default(false);
            $table->decimal('weight', 8, 3)->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();

            // --- Product Media ---
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();

            // --- Product Content ---
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();

            // --- Flags & Ratings ---
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('reviews_count')->default(0);
            $table->boolean('is_top_sale')->default(false);
            $table->boolean('is_featured')->default(false);

            // --- Vendor / Meta ---
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->string('vendor_name')->nullable();

            // --- Audit ---
            $table->timestamps();
            $table->softDeletes(); // Optional if you want soft delete functionality
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
