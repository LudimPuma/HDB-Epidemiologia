<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormularioVacunasCovid extends Model
{
    protected $table='epidemiologia.formulario_vacuna_covid_hospital';
    protected $primaryKey = 'id_f_covid_hospital';
    protected $fillable=['fecha','ci','vacuna','resultado'];


}
