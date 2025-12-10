<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HalalCertification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'reference_number',
        'file_path',
        'expiry_date',
        'status',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
