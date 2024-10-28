<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_model extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'customer_name', 'customer_street', 'customer_city', 'customer_zip_code', 
        'customer_phone', 'items', 'total_price'
    ];

    protected $casts = [
        'items' => 'array',
    ];
}
