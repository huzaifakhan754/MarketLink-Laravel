<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'farmer_id',
        'product_id',

        'customer_name',
        'customer_phone',
        'customer_email',

        'pickup_date',
        'time_slot',
        'pickup_name',

        'quantity',
        'price',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Customer
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Farmer
    |--------------------------------------------------------------------------
    */

    public function farmer()
    {
        return $this->belongsTo(Farmer::class, 'farmer_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Product
    |--------------------------------------------------------------------------
    */

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Feedback
    |--------------------------------------------------------------------------
    */

    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'order_id', 'id');
    }
}