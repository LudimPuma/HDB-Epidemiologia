<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bacteria extends Model
{
    protected $table='epidemiologia.bacterias';
    protected $primaryKey = 'cod_bacterias';
    protected $fillable=['nombre'];
    public $timestamps = false;
    public function antibiogramas()
    {
        return $this->hasMany(Antibiograma::class, 'cod_bacterias');
    }
    public function medicamentos()
    {
        return $this->belongsToMany(Medicamento::class, 'BACTERIAS_MEDICAMENTOS', 'COD_BACTE', 'COD_MEDI');
    }

}
