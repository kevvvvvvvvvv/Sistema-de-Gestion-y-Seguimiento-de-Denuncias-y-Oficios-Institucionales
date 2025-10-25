<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servidor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'servidor';
    protected $primaryKey = 'idServidor';
    protected $fillable = ['nombreCompleto', 'genero', 'grado', 'fechaIngreso',
        'puesto', 'nivel', 'correo', 'telefono', 'estatus', 'descripcion','idInstitucion', 'idDepartamento'];
    protected $dates = ['deleted_at'];
    public $timestamps = false;

    public function institucion(){
        return $this->belongsTo(Institucion::class, 'idInstitucion', 'idInstitucion')->withTrashed();
    }

    public function departamento(){
        return $this->belongsTo(Departamento::class, 'idDepartamento', 'idDepartamento')->withTrashed();
    }
}
