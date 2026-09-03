<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVerification extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'batch_number',
        'security_code',
        'is_verified',
        'verified_at',
        'ip_address',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
