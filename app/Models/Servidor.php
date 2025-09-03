<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{
    use HasFactory;

    protected $table = 'servidor';
    protected $primaryKey = 'idServidor';
    protected $fillable = ['nombreCompleto', 'genero', 'grado', 'fechaIngreso',
        'puesto', 'nivel', 'correo', 'telefono', 'estatus', 'descripcion','idInstitucion', 'idDepartamento'];
    public $timestamps = false;

    public function institucion(){
        return $this->belongsTo(Institucion::class, 'idInstitucion', 'idInstitucion');
    }

    public function departamento(){
        return $this->belongsTo(Departamento::class, 'idDepartamento', 'idDepartamento');
    }
}
