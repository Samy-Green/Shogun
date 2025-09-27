<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoPeriod extends Model
{
    use HasFactory;

    protected $table = 'promo_periods';

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Vérifie si la période est actuellement active
    public function getIsCurrentlyActiveAttribute()
    {
        $today = now()->toDateString();
        return $this->is_active && $today >= $this->start_date && $today <= $this->end_date;
    }

    public static function getLastActivePromoPeriod()
    {
        return self::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('end_date', 'desc')
            ->first();
    }
}
