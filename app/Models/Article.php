<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class Article extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = []; // or ['*']

    public static function boot()
    {
        parent::boot();
        static::creating(function($model) {
            $model->slug = \Str::slug($model->title.'-'. date('dmY'));
            $model->user_id = auth('sanctum')->user()->id ?? 0;
        });
    }

    public function getImageSourceUrlAttribute(){

        return asset('img/articles/'.$this->image );
    }
}
