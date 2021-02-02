<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number',
        'city',
        'address',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }

    public function items(){
        return $this->hasMany(
            Item::class,
            'order_id',
            'id'
        );
    }
}
