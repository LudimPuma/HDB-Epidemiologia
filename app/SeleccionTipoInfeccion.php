<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeleccionTipoInfeccion extends Model
{
    protected $table='epidemiologia.seleccion_tipo_infeccion';
    protected $primaryKey = 'id';
    protected $fillable=['cod_formulario','h_cli','cod_tipo_inf'];
    public $timestamps = false;
    public function formularioNotificacion()
    {
        return $this->belongsTo(FormularioNotificacionPaciente::class, 'cod_formulario');
    }

    public function datoPaciente()
    {
        return $this->belongsTo(DatoPaciente::class, 'h_cli');
    }

    public function tipoInfeccion()
    {
        return $this->belongsTo(TipoInfeccion::class, 'cod_tipo_inf');
    }

}
