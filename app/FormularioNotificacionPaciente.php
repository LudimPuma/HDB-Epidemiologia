<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormularioNotificacionPaciente extends Model
{
    protected $table='epidemiologia.formulario_notificacion_paciente';
    protected $primaryKey = 'cod_form_notificacion_p';
    // protected $fillable=['h_clinico','fecha_llenado','fecha_ingreso','servicio_inicio_sintomas','servicio_notificador','diagnostico_ingreso','diagnostico_sala','tipo_infeccion','uso_antimicrobanos','agente_causal','tipo_muestra_cultivo','procedimiento_invasivo','medidas_tomar','aislamiento','seguimiento','observacion'];
    protected $fillable=['h_clinico','fecha_llenado','fecha_ingreso','servicio_inicio_sintomas','servicio_notificador','diagnostico_ingreso','diagnostico_sala','uso_antimicrobanos','tipo_muestra_cultivo','procedimiento_invasivo','medidas_tomar','aislamiento','seguimiento','observacion','dias_internacion','estado','motivos_baja','pk_usuario'];
    public $timestamps = false;
    public function datoPaciente()
    {
        return $this->belongsTo(DatoPaciente::class,'h_clinico');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class,'servicio_inicio_sintomas');
    }

    public function servicioNotificador()
    {
        return $this->belongsTo(Servicio::class,'servicio_notificador');
    }

    public function procedimientoInvasivo()
    {
        return $this->belongsTo(ProcedimientoInmasivo::class,'procedimiento_invasivo');
    }
    public function tipoMuestra()
    {
        return $this->belongsTo(TipoMuestra::class,'tipo_muestra_cultivo');
    }
    public function antibiogramas()
    {
        return $this->hasMany(Antibiograma::class,'cod_form_notificacion_p');
    }
    public function seleccionesTipoInfeccion()
    {
        return $this->hasMany(SeleccionTipoInfeccion::class, 'cod_form_notificacion_p');
    }
    public function seleccionesHongos()
    {
        return $this->hasMany(SeleccionHongos::class, 'cod_form_notificacion_p');
    }
    public function usuarioCreador()
    {
        return User::where('id', $this->pk_usuario)->first();
    }

    public function getNombreCreadorAttribute()
    {
        return $this->creador->persona->nombres . ' ' . $this->creador->persona->apellidos;
    }
}
