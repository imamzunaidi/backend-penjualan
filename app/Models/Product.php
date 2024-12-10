<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name_product', 'category_id', 'brand_id', 'piace_id', 'description', 'price', 'code_product', 'image'];

}
