<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patologia extends Model
{
    protected $table='epidemiologia.patologia';
    protected $primaryKey = 'cod_patologia';
    protected $fillable=['nombre','estado','motivos_baja'];
    public $timestamps = false;

    public function formulariosEnfermedadesNotificacionesInmediatas()
    {
        return $this->hasMany(FormularioEnfermedadesNotificacionInmediata::class);
    }
}
