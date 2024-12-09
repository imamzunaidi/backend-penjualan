<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected $fillable = ['name_product', 'category_id', 'brand_id', 'peace_id', 'description', 'price', 'code_product', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function peace()
    {
        return $this->belongsTo(Peace::class);
    }
}
