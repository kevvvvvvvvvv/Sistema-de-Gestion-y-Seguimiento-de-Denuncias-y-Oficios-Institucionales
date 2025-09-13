<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Particular extends Model
{
    protected $table = 'particular';
    protected $primaryKey = 'idParticular';
    public $timestamps = false;

    protected $fillable = [
        'nombreCompleto',
        'genero',
        'grado',
    ];
}
