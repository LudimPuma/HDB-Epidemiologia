<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antibiograma extends Model
{
    protected $table='epidemiologia.antibiograma';
    protected $primaryKey = 'id_antibiograma';
    protected $fillable=['cod_formulario','cod_bacte'];

    public function formularioNotificacion()
    {
        return $this->belongsTo(FormularioNotificacionPaciente::class,'cod_formulario');
    }

    public function bacteria()
    {
        return $this->belongsTo(Bacteria::class,'cod_bacte');
    }

    public function nivelesAntibiogramas()
    {
        return $this->hasMany(NivelAntibiograma::class);
    }
}
