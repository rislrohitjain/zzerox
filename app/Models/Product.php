<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'dosage_form',
        'pack_size',
        'description',
        'chemical_characteristics',
        'side_effects',
        'administration_uses',
        'image_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function verifications()
    {
        return $this->hasMany(ProductVerification::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order', 'asc');
    }
}
