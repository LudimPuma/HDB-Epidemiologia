<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    protected $table='epidemiologia.medicamentos';
    protected $primaryKey = 'cod_medicamento';
    protected $fillable=['nombre','estado','motivos_baja'];
    public $timestamps = false;
    public function antibiogramas()
    {
        return $this->hasMany(Antibiograma::class, 'cod_medicamento');
    }
    public function bacterias()
    {
        return $this->belongsToMany(Bacteria::class, 'epidemiologia.bacterias_medicamentos', 'cod_medi', 'cod_bacte');
    }
}
