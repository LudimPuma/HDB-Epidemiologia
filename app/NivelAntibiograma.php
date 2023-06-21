<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NivelAntibiograma extends Model
{
    protected $table='epidemiologia.niveles_antibiograma';
    protected $primaryKey = 'id_niveles';
    protected $fillable=['id_antibio','cod_med','nivel'];

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class,'cod_med');
    }

    public function antibiograma()
    {
        return $this->belongsTo(Antibiograma::class,'id_antibio');
    }

}
