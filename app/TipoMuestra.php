<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMuestra extends Model
{
    protected $table='epidemiologia.tipo_muestra';
    protected $primaryKey = 'cod_tipo_muestra';
    protected $fillable=['nombre','estado','motivos_baja'];
    public $timestamps = false;

    public function formulariosNotificacionesPacientes()
    {
        return $this->hasMany(FormularioNotificacionPaciente::class);
    }
}
