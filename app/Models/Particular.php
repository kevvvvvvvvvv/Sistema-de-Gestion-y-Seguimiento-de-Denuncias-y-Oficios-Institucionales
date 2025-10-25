<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Particular extends Model
{
    use SoftDeletes;

    protected $table = 'particular';
    protected $primaryKey = 'idParticular';
    protected $dates = ['deleted_at'];
    public $timestamps = false;

    protected $fillable = [
        'nombreCompleto',
        'genero',
        'grado',
    ];
}
