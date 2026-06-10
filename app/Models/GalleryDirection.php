<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryDirection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_fr',
        'description_en',
        'description_fr',
        'image',
    ];

    /**
     * Retourne l’URL publique de l’image.
     */
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset($this->image) : null;
    }
}
