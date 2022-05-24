<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Declaration extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function getFile_1Attribute(){

        return asset('documents/uploads/'.$this->file_justification_1 );
    }
    public function getFile_2Attribute(){

        
        return asset('documents/uploads/'.$this->file_justification_2 );
    }
    public function getFile_3Attribute(){

        
        return asset('documents/uploads/'.$this->file_justification_3 );
    }
}
