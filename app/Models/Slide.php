<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function boot(){
        parent::boot();

        self::creating(function($model){
            $model->user_id = auth('sanctum')->user()->id;
        });
    }
}
