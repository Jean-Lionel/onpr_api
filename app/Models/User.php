<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Institution;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $fillable = [
        'name',
        'email',
        'password',
        'telephone',
        'mobile',
        'description',
        'role_id',
        'is_active',
        'institution_id',
        'numero_matricule',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class,  'role_id','id');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function isAdmin(){

        return $this->role->name === 'ADMINISTRATEUR';
    } 
    public function isEmployeur(){

        return $this->role->name === 'EMPLOYEUR';
    }
    public function isChefRecouvrement(){

        return $this->role->name === 'CHEF RECOUVREMENT';
    } 
    public function isRisqueProfessionnel(){

        return $this->role->name === 'RISQUE PROFESSIONELLE';
    }    
    public function isWebAdministrateur(){

        return $this->role->name === 'ADMINISTRATEUR WEB';
    }
    public function isMembre(){

        return $this->role->name === 'MEMBRE';
    } 
}
