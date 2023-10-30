<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    public $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'email',
        'password',
        'persona_id',
        'estado',
        'profesion',
        'matricula_profesion',
        'matricula_colegio',
        'cargo',
        'area',
        'resgister',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // public function persona()
    // {
    //     return $this->belongsTo(Persona::class);
    // }
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id', 'id');
    }
}
