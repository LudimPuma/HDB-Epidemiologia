<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agente extends Model
{
    protected $table = 'epidemiologia.agente_causal';
    protected $primaryKey = 'cod_agente_causal';

    protected $fillable = ['nombre'];
    public $timestamps = false;

    // public function formulariosNotificacionesPacientes()
    // {
    //     return $this->hasMany(FormularioNotificacionPaciente::class);
    // }
}
