<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oficio extends Model
{
    protected $table = 'oficio';
    public $incrementing = false;       
    protected $keyType = 'string';       

    protected $primaryKey = 'numOficio';

    protected $fillable = [
        'numOficio', 
        'fechaLlegada', 
        'fechaCreacion', 
        'url',
        'idServidorRemitente', 
        'idParticularRemitente', 
        'idDepartamentoRemitente',
        'idServidorDestinatario', 
        'idParticularDestinatario', 
        'idDepartamentoDestinatario'
    ];

    public $timestamps = false;

    public function servidor(){
        return $this->belongsTo(Servidor::class, 'idRemitente', 'idServidor');
    }

    public function destinatario(){
        return $this->belongsTo(Destinatario::class, 'idDestinatario', 'idDestinatario');
    }

    public function departamentoD() {
        return $this->hasOneThrough(
            Departamento::class,
            Destinatario::class,
            'idDestinatario', // FK en Destinatario que apunta a Oficio
            'idDepartamento', // PK en Departamento
            'idDestinatario', // Local key en Oficio
            'idDepartamento'  // Local key en Destinatario
        );
    }

}
