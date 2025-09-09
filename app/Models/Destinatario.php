<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destinatario extends Model
{
    protected $table = 'destinatario';

    protected $primaryKey = 'idDestinatario';

    protected $fillable = [
        'tipo', 
        'idServidor', 
        'idDepartamento', 
    ];

    public $timestamps = false;

    public function servidor(){
        return $this->belongsTo(Servidor::class, 'idServidor', 'idServidor');
    }

    public function departamento(){
        return $this->belongsTo(Departamento::class, 'idDepartamento', 'idDepartamento');
    }

    public function departamentoD()
    {
        return $this->hasOneThrough(
            Departamento::class,  // Modelo final
            Destinatario::class,  // Modelo intermedio
            'idDestinatario',     // FK en Destinatario que apunta a Oficio
            'idDepartamento',     // PK en Departamento
            'idDestinatario',     // Local key en Oficio
            'idDepartamento'      // Local key en Destinatario
        );
    }
}
