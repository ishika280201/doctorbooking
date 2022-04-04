<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    protected $fillable = [
        'title',
        'description',
        'price',
        'status',
        'category_id',
        'sku',
        'image',
    ];

    public function images(){
        return $this->hasMany('App\Models\Image','product_id');
    }
}
