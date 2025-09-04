<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expediente extends Model
{
    use HasFactory;

    protected $table = 'expediente';
    public $incrementing = false;
    protected $keyType = 'string'; 

    protected $primaryKey = 'numero';
    protected $fillable = ['numero', 'ofRequerimiento', 'fechaRequerimiento', 'ofRespuesta', 
    'fechaRespuesta', 'fechaRecepcion', 'idServidor'];
    public $timestamps = false;

    public function servidor(){
        return $this->belongsTo(Servidor::class, 'idServidor', 'idServidor');
    }
}
