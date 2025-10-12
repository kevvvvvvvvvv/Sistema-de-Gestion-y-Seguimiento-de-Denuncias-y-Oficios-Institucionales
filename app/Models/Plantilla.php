<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plantilla extends Model
{
    use HasFactory;

    protected $table = 'plantilla';
    protected $primaryKey = 'idPlantilla';
    protected $fillable = ['titulo', 'contenido'];
    public $timestamps = false;
}
