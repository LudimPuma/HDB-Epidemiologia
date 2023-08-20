<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatoPaciente extends Model
{
    protected $table='epidemiologia.datos_paciente';
    protected $primaryKey = 'n_h_clinico';
    protected $fillable=['ap_paterno','ap_materno','nombre_paciente','sexo','edad'];

    public function formulariosNotificacionesPacientes()
    {
        return $this->hasMany(FormularioNotificacionPaciente::class);
    }

    public function formulariosEnfermedadesNotificacionesInmediatas()
    {
        return $this->hasMany(FormularioEnfermedadesNotificacionInmediata::class);
    }

    public function antibiogramas()
    {
        return $this->hasMany(Antibiograma::class,'n_h_clinico');
    }
    public function seleccionesTipoInfeccion()
    {
        return $this->hasMany(SeleccionTipoInfeccion::class,'n_h_clinico');
    }
}
