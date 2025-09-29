<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cost',
        'city_id',
    ];

    /**
     * Get the city that owns the neighborhood.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
