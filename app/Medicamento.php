<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    protected $table='epidemiologia.medicamentos';
    protected $primaryKey = 'cod_medicamento';
    protected $fillable=['nombre'];
    public $timestamps = false;
    public function antibiogramas()
    {
        return $this->hasMany(Antibiograma::class, 'cod_medicamento');
    }

}
