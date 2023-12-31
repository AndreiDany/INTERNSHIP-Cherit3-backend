<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    //protected $table = 'orders';
    protected $primary_key = [
        'id'
    ];

    protected $fillable = [
        'user_id',
        'address',
        'price',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}