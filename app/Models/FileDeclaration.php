<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileDeclaration extends Model
{
    use HasFactory;
    protected $guarded = [];

   // public function name
    public function getNameAttribute($v){
        return asset('uploads/form/'.$v);
    }
}
