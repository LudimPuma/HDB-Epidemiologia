<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeleccionHongos extends Model
{
    protected $table='epidemiologia.seleccion_hongos';
    protected $primaryKey = 'id';
    protected $fillable=['cod_formulario','h_cli','id_hongos'];
    public $timestamps = false;
    public function formulariosNotificacionPaciente()
    {
        return $this->belongsTo(FormularioNotificacionPaciente::class, 'cod_formulario');
    }
    public function datoPaciente()
    {
        return $this->belongsTo(DatoPaciente::class, 'h_cli');
    }

    public function Hongo()
    {
        return $this->belongsTo(Hongo::class, 'id_hongos');
    }
}
