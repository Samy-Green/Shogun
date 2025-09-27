<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    use HasFactory;

    protected $table = 'carousels';

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'title',
        'description',
        'button_icon',
        'button_text',
        'button_link',
        'image',
    ];

    /**
     * Si tu veux obtenir le chemin complet de l'image depuis les assets
     */
    public function getImagePathAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
