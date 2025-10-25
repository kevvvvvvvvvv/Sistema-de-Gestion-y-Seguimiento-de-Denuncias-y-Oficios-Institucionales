<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expediente extends Model
{
    use HasFactory;

    protected $table = 'expediente';

    protected $primaryKey = 'numero';
    public $incrementing = false;
    protected $keyType = 'string'; 
    protected $fillable = ['numero', 'ofRequerimiento', 'fechaRequerimiento', 'ofRespuesta', 
    'fechaRespuesta', 'fechaRecepcion', 'idServidor'];
    public $timestamps = false;

    public function servidor(){
        return $this->belongsTo(Servidor::class, 'idServidor', 'idServidor')->withTrashed();;
    }

    public function control()
    {
        return $this->hasOne(Control::class, 'numero', 'numero');
    }
}
