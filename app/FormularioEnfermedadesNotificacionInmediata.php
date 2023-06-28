<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormularioEnfermedadesNotificacionInmediata extends Model
{
    protected $table='epidemiologia.formulario_enfermedades_notificacion_inmediata';
    protected $primaryKey = 'id_f_notificacion_inmediata';
    protected $fillable=['h_clinico','fecha','cod_pato','cod_servi','notificador','acciones','observaciones'];
    public $timestamps = false;
    public function datoPaciente()
    {
        return $this->belongsTo(DatoPaciente::class,'h_clinico');
    }

    public function patologia()
    {
        return $this->belongsTo(Patologia::class,'cod_pato');
    }
    public function servicio()
    {
        return $this->belongsTo(Servicio::class,'cod_servi');
    }
}
