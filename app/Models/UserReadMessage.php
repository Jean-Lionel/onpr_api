<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReadMessage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function boot(){
        parent::boot();
        
        self::creating(function($model){
            $model->user_id = auth('sanctum')->user()->id;
        });
    }
}
