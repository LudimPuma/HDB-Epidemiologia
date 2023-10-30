<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bacteria extends Model
{
    protected $table='epidemiologia.bacterias';
    protected $primaryKey = 'cod_bacterias';
    protected $fillable=['nombre','estado','motivos_baja'];
    public $timestamps = false;
    public function antibiogramas()
    {
        return $this->hasMany(Antibiograma::class, 'cod_bacterias');
    }
    public function medicamentos()
    {
        return $this->belongsToMany(Medicamento::class, 'epidemiologia.bacterias_medicamentos', 'cod_bacte', 'cod_medi');
    }
}
