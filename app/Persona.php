<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'personas';

    // Columna de la clave primaria
    protected $primaryKey = 'id';
    protected $fillable = ['nombres'];

    // Relación con el modelo User
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
