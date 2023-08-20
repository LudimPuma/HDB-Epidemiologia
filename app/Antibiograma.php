<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antibiograma extends Model
{
    protected $table='epidemiologia.antibiograma';
    protected $primaryKey = 'id';
    protected $fillable=['cod_formulario','h_cli','cod_bacte','cod_medi','nivel'];
    public $timestamps = false;
    public function formularioNotificacion()
    {
        return $this->belongsTo(FormularioNotificacionPaciente::class,'cod_formulario');
    }
    public function datoPaciente()
    {
        return $this->belongsTo(DatoPaciente::class, 'h_cli');
    }

    public function bacteria()
    {
        return $this->belongsTo(Bacteria::class,'cod_bacte');
    }
    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class, 'cod_medi');
    }
}
