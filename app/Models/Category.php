<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'parent_id',
        'icon',
        'color',
        'is_primary',
        'image',
    ];

    /**
     * Relation vers la catégorie parent.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Relation vers les catégories enfants.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getCountChildrenAttribute()
    {
        return $this->children()->count();
    }

    // Produits associés
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }

    public function getTotalProductsCountAttribute()
{
    // Commence par les IDs de cette catégorie et de tous ses enfants
    $categoryIds = $this->children()->pluck('id')->toArray();
    $categoryIds[] = $this->id;

    // Récupère les IDs uniques des produits associés à ces catégories
    return DB::table('category_product')
        ->whereIn('category_id', $categoryIds)
        ->distinct('product_id')
        ->count('product_id');
}


    public function getCountProductsAttribute()
    {
        return $this->products()->count();
    }
}
