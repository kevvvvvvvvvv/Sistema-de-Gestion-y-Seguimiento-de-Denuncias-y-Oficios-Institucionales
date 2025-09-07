<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Viajero extends Model
{
    protected $table = 'viajero';

    protected $primaryKey = 'folio';

    protected $fillable = [
        'asutno', 
        'instruccion', 
        'resultado', 
        'fechaEntrega',
        'status', 
        'numOficio',
        'idUsuario'
    ];

    public $timestamps = false;

    public function remitente(){
        return $this->belongsTo(Institucion::class, 'idRemitente', 'idRemitente');
    }

    public function destinatario(){
        return $this->belongsTo(Departamento::class, 'idDestinatario', 'idDestinatario');
    }
}
