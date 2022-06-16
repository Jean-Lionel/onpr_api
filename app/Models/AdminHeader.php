<?php

namespace App\Models;

use App\Models\AdminContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminHeader extends Model
{
    use HasFactory;
   // use SoftDeletes;
    protected $guarded = [];

    public function admin_contents(){

        return $this->hasMany(AdminContent::class,  'admin_header_id','id');
    }
}
