<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table='epidemiologia.servicio';
    protected $primaryKey = 'cod_servicio';
    protected $fillable=['nombre','estado','motivos_baja'];
    public $timestamps = false;
    public function formulariosNotificacionesPacientes()
    {
        return $this->hasMany(FormularioNotificacionPaciente::class);
    }

    public function formulariosEnfermedadesNotificacionesInmediatas()
    {
        return $this->hasMany(FormularioEnfermedadesNotificacionInmediata::class);
    }
}
