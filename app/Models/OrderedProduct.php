<?php

namespace App\Models;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderedProduct extends Model
{
    use HasFactory;
    protected $table = 'ordered_products';
    protected $primary_key = [
        'id'
    ];

    protected $fillable = [
        'product_id',
        'order_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}