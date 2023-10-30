<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'ci',
        'extension',
        'nombres',
        'apellidos',
        'genero',
        'direccion',
        'telefono',
        'celular',
        'fecha_nacimiento',
        'estado_civil',
        'resgister',
    ];

    // public function user()
    // {
    //     return $this->hasOne(User::class);
    // }
    public function users()
    {
        return $this->hasMany(User::class, 'persona_id', 'id');
    }
}
