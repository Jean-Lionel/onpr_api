<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slide extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public static function boot(){
        parent::boot();
        
        self::creating(function($model){
            $model->user_id = auth('sanctum')->user()->id;
        });
    }

    public function getImageAttribute($v){
        return asset('img/slides/'.$v);
    }
}
