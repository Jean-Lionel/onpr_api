<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineDeclarationDetache extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

   
    public function getFileUploadedOneAttribute($v)
    {
        return asset('documents/declaration/'. $v);
    }

    public function getFileUploadedTwoAttribute($value)
    {
        return asset('documents/declaration/'.$value);
    }
}
