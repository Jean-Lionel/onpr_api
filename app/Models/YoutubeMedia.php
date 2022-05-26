<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class YoutubeMedia extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static function boot(){
        parent::boot();

        self::creating(function($model){
            $model->user_id = auth('sanctum')->user()->id;

        });
    }
}
