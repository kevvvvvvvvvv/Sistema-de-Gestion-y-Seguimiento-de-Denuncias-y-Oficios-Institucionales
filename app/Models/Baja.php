<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baja extends Model
{
    use HasFactory;

    protected $table = 'baja';
    protected $primaryKey = 'idBaja';
    protected $fillable = ['puestoAnt', 'nivelAnt', 'adscripcionAnt', 
    'fechaIngresoAnt', 'fechaBaja', 'descripcion','numero', 'idServidor'];
    public $timestamps = false;

    public function expediente(){
        return $this->belongsTo(Expediente::class, 'numero', 'numero');
    }

    public function servidor(){
        return $this->belongsTo(Servidor::class, 'idServidor', 'idServidor');
    }
}
