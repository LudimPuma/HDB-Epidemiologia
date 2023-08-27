<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeleccionPatologia extends Model
{
    protected $table='epidemiologia.seleccion_patologia';
    protected $primaryKey = 'id';
    protected $fillable=['cod_form_n_i','h_cli','cod_pato'];
    public $timestamps = false;
    public function formulariosEnfermedadesNotificacionesInmediatas()
    {
        return $this->belongsTo(FormularioEnfermedadesNotificacionInmediata::class, 'cod_form_n_i');
    }
    public function datoPaciente()
    {
        return $this->belongsTo(DatoPaciente::class, 'h_cli');
    }

    public function Patologia()
    {
        return $this->belongsTo(Patologia::class, 'cod_pato');
    }
}
