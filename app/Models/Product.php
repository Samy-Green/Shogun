<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'full_name',
        'description',
        'price',
        'quantity',
        'available',
        'main_category_id',
        'discount',
        'discount_end_date',
        'deal',
        'luxury',
        'image',
        'weight',
        'status',
        'promo_message',
        'is_active',
        'is_coming',
        'purchase_price',
        'long_description',
    ];

    // Catégorie principale
    public function mainCategory()
    {
        return $this->belongsTo(Category::class, 'main_category_id');
    }

    // Catégories multiples
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function getReductionAttribute()
    {
        $discount = 0;
        $deal = 0;

        $lastPromo = PromoPeriod::getLastActivePromoPeriod();
        if ($lastPromo && $lastPromo->is_currently_active) {
            $deal = $lastPromo->deal;
        }

        if (!($this->discount_end_date && $this->discount_end_date < now())) {
            $discount = $this->attributes['discount']; // <-- éviter la récursion
        }

        return max($discount, $deal);
    }

    public function files()
    {
        return $this->belongsToMany(\App\Models\File::class, 'product_file');
    }


}
