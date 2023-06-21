<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patologia extends Model
{
    protected $table='epidemiologia.patologia';
    protected $primaryKey = 'cod_patologia';
    protected $fillable=['nombre'];

    public function formulariosEnfermedadesNotificacionesInmediatas()
    {
        return $this->hasMany(FormularioEnfermedadesNotificacionInmediata::class);
    }
}
