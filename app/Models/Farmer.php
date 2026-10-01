<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    protected $fillable = [
        'user_id',
        'market_id',
        'status',
        'farm_name',
        'image',
        'description',
        'operating_days',
        'pickup_window',
        'location',
        'latitude',
        'longitude',
    ];

    /**
     * Farmer belongs to a Market.
     */
    public function market()
    {
        return $this->belongsTo(Market::class, 'market_id');
    }

    /**
     * Farmer belongs to User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Farmer has many Products through user_id.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id', 'user_id');
    }
}