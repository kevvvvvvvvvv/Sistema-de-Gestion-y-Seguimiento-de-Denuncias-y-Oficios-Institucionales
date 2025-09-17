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

    public function departamentoRemitente(){
        return $this->belongsTo(Departamento::class, 'idDepartamentoRemitente', 'idDepartamento');
    }

    public function servidorRemitente(){
        return $this->belongsTo(Servidor::class, 'idServidorRemitente', 'idServidor');
    }

    public function particularRemitente(){
        return $this->belongsTo(Destinatario::class, 'idParticularRemitente', 'idParticular');
    }


    public function departamentoDestinatario(){
        return $this->belongsTo(Departamento::class, 'idDepartamentoRemitente', 'idDepartamento');
    }

    public function servidorDestinatario(){
        return $this->belongsTo(Servidor::class, 'idServidorRemitente', 'idServidor');
    }

    public function particularDestinatario(){
        return $this->belongsTo(Destinatario::class, 'idParticularRemitente', 'idParticular');
    }

}
