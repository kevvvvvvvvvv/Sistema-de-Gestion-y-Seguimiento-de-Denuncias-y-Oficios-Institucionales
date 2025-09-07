<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oficio extends Model
{
    protected $table = 'oficio';

    protected $primaryKey = 'idServidor';
    protected $fillable = [
        'numOficio', 
        'fechaLlegada', 
        'fechaCreacion', 
        'url',
        'idRemitente', 
        'idDestinatario'
    ];

    public $timestamps = false;

    public function remitente(){
        return $this->belongsTo(Servidor::class, 'idRemitente', 'idServidor');
    }

    public function destinatario(){
        return $this->belongsTo(Destinatario::class, 'idDestinatario', 'idDestinatario');
    }
}
