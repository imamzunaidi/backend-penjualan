<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailCheckout extends Model
{
    use HasFactory;
    
    protected $fillable = ['qty', 'product_id', 'price_item', 'checkout_id'];
}
