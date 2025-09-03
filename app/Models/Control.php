<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    use HasFactory;

    protected $table = 'control';
    protected $primaryKey = 'consecutivo';
    protected $fillable = ['acProrroga', 'acAuxilio', 'acRegularizacion', 
    'acRequerimiento', 'acOficioReque', 'acConclusion', 'comentarios'];
    public $timestamps = false;
}
