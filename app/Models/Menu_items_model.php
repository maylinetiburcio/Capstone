<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu_items_model extends Model
{
    use HasFactory;
    
    protected $table = 'menu_items';
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category_id'
    ];
    
}
