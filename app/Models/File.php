<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name',
        'path',
        'mime_type',
        'size',
    ];

    // Relation polymorphique
    public function fileable()
    {
        return $this->morphTo();
    }

    // URL publique du fichier
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }

    public function products()
    {
        return $this->belongsToMany(\App\Models\Product::class, 'product_file');
    }

}
