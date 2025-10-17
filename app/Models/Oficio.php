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
        'idInstitucionRemitente',

        'idServidorDestinatario', 
        'idParticularDestinatario', 
        'idDepartamentoDestinatario',
        'idInstitucionDestinatario',
    ];

    public $timestamps = false;

    public function departamentoRemitente(){
        return $this->belongsTo(Departamento::class, 'idDepartamentoRemitente', 'idDepartamento')->withTrashed();
    }

    public function institucionRemitente(){
        return $this->belongsTo(Institucion::class, 'idInstitucionRemitente', 'idInstitucion');
    }

    public function servidorRemitente(){
        return $this->belongsTo(Servidor::class, 'idServidorRemitente', 'idServidor');
    }

    public function particularRemitente(){
        return $this->belongsTo(Particular::class, 'idParticularRemitente', 'idParticular');
    }


    public function departamentoDestinatario(){
        return $this->belongsTo(Departamento::class, 'idDepartamentoDestinatario', 'idDepartamento')->withTrashed();
    }

    public function servidorDestinatario(){
        return $this->belongsTo(Servidor::class, 'idServidorDestinatario', 'idServidor');
    }

    public function particularDestinatario(){
        return $this->belongsTo(Particular::class, 'idParticularDestinatario', 'idParticular');
    }

    public function institucionDestinatario(){
        return $this->belongsTo(Institucion::class, 'idInstitucionDestinatario', 'idInstitucion');
    }

}
