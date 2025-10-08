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
        return asset($this->path);
    }

    public function products()
    {
        return $this->belongsToMany(\App\Models\Product::class, 'product_file');
    }


    /**
     * Accesseur pour obtenir l'icône et la couleur basées sur l'extension du fichier.
     *
     * @return array{icon: string, color: string}
     */
    public function getIconAttribute(): array
    {
        // Retourne l'icône par défaut si le chemin du fichier est manquant ou vide.
        if (empty($this->path)) {
            return ['icon' => 'ti ti-file', 'color' => 'text-muted'];
        }

        $extension = strtolower(pathinfo($this->path, PATHINFO_EXTENSION));

        return match($extension) {
            // Images
            'jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp' => ['icon' => 'ti ti-photo', 'color' => 'text-info'],

            // Vidéos
            'mp4', 'mkv', 'mov', 'avi', 'webm' => ['icon' => 'ti ti-device-tv', 'color' => 'text-warning'],

            // Audio
            'mp3', 'wav', 'ogg', 'm4a' => ['icon' => 'ti ti-music', 'color' => 'text-info'],

            // Documents
            'pdf' => ['icon' => 'ti ti-file-text', 'color' => 'text-danger'], // PDF
            'doc', 'docx' => ['icon' => 'ti ti-file-text', 'color' => 'text-primary'], // Word
            'xls', 'xlsx', 'csv' => ['icon' => 'ti ti-file-text', 'color' => 'text-success'], // Excel
            'ppt', 'pptx' => ['icon' => 'ti ti-file-text', 'color' => 'text-warning'], // PowerPoint

            // Archives
            'zip', 'rar', '7z', 'tar', 'gz' => ['icon' => 'ti ti-folder-zip', 'color' => 'text-secondary'],

            // Défaut
            default => ['icon' => 'ti ti-file', 'color' => 'text-muted'],
        };
    }

}
