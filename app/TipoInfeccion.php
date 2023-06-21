<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoInfeccion extends Model
{
    protected $table='epidemiologia.tipo_infeccion';
    protected $primaryKey = 'cod_tipo_infeccion';
    protected $fillable=['nombre'];
    public $timestamps = false;

    public function formulariosNotificacionesPacientes()
    {
        return $this->hasMany(FormularioNotificacionPaciente::class);
    }
}
