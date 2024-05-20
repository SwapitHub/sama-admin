<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrecentageDiscount extends Model
{
    use HasFactory;
	protected $table = 'product_price_discount';
	protected $guarded = [];
}
