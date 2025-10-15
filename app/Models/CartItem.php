<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'variant_id',
        'name',
        'sku',
        'image',
        'quantity',
        'price',
        'discount',
        'tax_rate',
        'tax_amount',
        'subtotal',
        'total',
        'attributes',
        'vendor_id',
    ];

    protected $casts = [
        'attributes' => 'array',
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax_rate' => 'decimal:4',
        'tax_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
