<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    use HasFactory;
    protected $guarded = [];
	protected $table='orders';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
