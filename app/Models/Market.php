<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    protected $fillable = [
        'name',
        'location',
        'days',
        'timing',
        'image',
    ];

    /**
     * Market has many farmers/vendors.
     */
    public function farmers()
    {
        return $this->hasMany(Farmer::class, 'market_id');
    }
}