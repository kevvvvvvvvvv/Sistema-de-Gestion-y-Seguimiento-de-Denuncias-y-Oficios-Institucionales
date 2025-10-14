<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'departamento';
    protected $primaryKey = 'idDepartamento';
    protected $fillable = ['nombre', 'idInstitucion'];
    protected $dates = ['deleted_at'];
    public $timestamps = false;

    public function institucion(){
        return $this->belongsTo(Institucion::class, 'idInstitucion', 'idInstitucion');
    }
}
