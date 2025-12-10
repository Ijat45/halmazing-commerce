<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the display name for the vendor (Branch Name > Business Name > Name).
     */
    public function getVendorDisplayNameAttribute()
    {
        // 1. Try Branch Name
        if ($this->branches->isNotEmpty()) {
            return $this->branches->first()->name;
        }

        // 2. Try Business Name
        if ($this->vendor && !empty($this->vendor->merchant_info['business_name'])) {
            return $this->vendor->merchant_info['business_name'];
        }

        // 3. Fallback to Vendor Name
        return $this->vendor->name ?? 'Unknown Vendor';
    }

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'category',
        'brand_id',
        'brand',
        'price',
        'regular_price',
        'sale_price',
        'discount_type',
        'discount_value',
        'discounted_price',
        'tax_rate',
        'stock_quantity',
        'is_in_stock',
        'backorder_allowed',
        'weight',
        'length',
        'width',
        'height',
        'image',
        'gallery',
        'description',
        'short_description',
        'rating',
        'reviews_count',
        'is_top_sale',
        'is_featured',
        'vendor_id',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'regular_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'tax_rate' => 'decimal:4',
        'weight' => 'decimal:3',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'rating' => 'decimal:2',
        'gallery' => 'array',
        'is_in_stock' => 'boolean',
        'backorder_allowed' => 'boolean',
        'is_top_sale' => 'boolean',
        'is_featured' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the product's generated SKU if not set.
     */
    public function getSkuAttribute($value): string
    {
        // Return the stored SKU if it exists, otherwise generate one
        if ($value) {
            return $value;
        }

        // Generate SKU from category and ID: "SNACKS-123"
        return $this->category ? strtoupper($this->category) . '-' . $this->id : 'PROD-' . $this->id;
    }

    /**
     * Automatically create a slug from the name when creating a product.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    protected static function booted()
    {
        static::addGlobalScope(new \App\Models\Scopes\MerchantScope);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_product');
    }

    public function halalCertification()
    {
        return $this->hasOne(HalalCertification::class);
    }
}
