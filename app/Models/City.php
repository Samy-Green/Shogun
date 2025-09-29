<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'delivery',
        'cost',
    ];

    /**
     * Get the neighborhoods for the city.
     */
    public function neighborhoods()
    {
        return $this->hasMany(Neighborhood::class);
    }
}
