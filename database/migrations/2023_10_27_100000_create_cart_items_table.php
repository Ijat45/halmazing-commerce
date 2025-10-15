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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable()->index(); // For guest carts
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->string('name');
            $table->string('sku');
            $table->string('image')->nullable();
            $table->unsignedInteger('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax_rate', 5, 4)->default(0.0000);
            $table->decimal('tax_amount', 10, 2);
            $table->decimal('subtotal', 10, 2); // price * quantity
            $table->decimal('total', 10, 2); // subtotal + tax_amount - discount
            $table->json('attributes')->nullable(); // For product options like color, size
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
