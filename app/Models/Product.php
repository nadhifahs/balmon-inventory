<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'product_category_id',
        'brand',
        'type',
        'series',
        'condition',
        'year'
    ];

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function cart_detail()
    {
        return $this->hasMany(CartDetail::class);
    }
}
