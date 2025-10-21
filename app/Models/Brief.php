<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brief extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'briefs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'source',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Scope pour obtenir les brèves publiées
     */
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now())
                    ->orderBy('published_at', 'desc');
    }

    /**
     * Scope pour obtenir les brèves récentes
     */
    public function scopeRecent($query, $limit = 10)
    {
        return $query->published()
                    ->limit($limit);
    }

    /**
     * Scope pour rechercher dans les brèves
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('source', 'like', "%{$search}%");
            });
        }
        return $query;
    }

    /**
     * Scope pour filtrer par date
     */
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('published_at', $date);
    }

    /**
     * Accessor pour obtenir un extrait du contenu
     */
    public function getExcerptAttribute($length = 100)
    {
        return substr($this->content, 0, $length) . '...';
    }
}
