<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Viajero extends Model
{
    protected $table = 'viajero';

    protected $primaryKey = 'folio';

    protected $fillable = [
        'folio',
        'asunto', 
        'instruccion', 
        'resultado', 
        'fechaEntrega',
        'status', 
        'numOficio',
        'idUsuario'
    ];

    public $timestamps = false;

    public function getRouteKeyName()
    {
        return 'folio'; 
    }

    public function oficio(){
        return $this->belongsTo(Oficio::class, 'numOficio', 'numOficio');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'idUsuario', 'idUsuario');
    }
}
