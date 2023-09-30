<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hongo extends Model
{
    protected $table = 'epidemiologia.hongos';
    protected $primaryKey = 'id';

    protected $fillable = ['nombre'];
    public $timestamps = false;


}
