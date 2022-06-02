<?php

namespace App\Models;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CotisationAfilier extends Model
{
    use HasFactory;

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
