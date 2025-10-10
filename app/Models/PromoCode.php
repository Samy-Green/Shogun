<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;

    protected $table = 'promo_codes';

    /**
     * Les attributs pouvant être remplis en masse.
     */
    protected $fillable = [
        'code',
        'owner_name',
        'owner_phone',
        'discount',
    ];

    /**
     * Optionnel : convertir le discount en pourcentage lisible.
     */
    public function getHumanDiscountAttribute(): string
    {
        $discount = $this->discount > 1 ? $this->discount : $this->discount * 100;
        return number_format($discount, $this->discount >= 1 ? 0 : 2, ',', ' ') . ($this->discount > 1 ? ' FCFA' : '%');
    }
}
