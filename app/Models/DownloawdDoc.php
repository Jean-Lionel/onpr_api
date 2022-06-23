<?php

namespace App\Models;

use App\Models\FileDeclaration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DownloawdDoc extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function documents(){

        return $this->hasMany(FileDeclaration::class,  'downloawd_doc_id','id');
    }
}
