<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcedimientoInmasivo extends Model
{
    protected $table='epidemiologia.procedimiento_invasivo';
    protected $primaryKey = 'cod_procedimiento_invasivo';
    protected $fillable=['nombre','estado','motivos_baja'];
    public $timestamps = false;

    public function formulariosNotificacionesPacientes()
    {
        return $this->hasMany(FormularioNotificacionPaciente::class);
    }
}
