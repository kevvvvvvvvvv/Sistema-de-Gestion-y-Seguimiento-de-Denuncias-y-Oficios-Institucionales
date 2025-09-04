<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    use HasFactory;

    protected $table = 'control';
    protected $primaryKey = 'consecutivo';
    protected $fillable = ['acProrroga', 'acAuxilio', 'acRegularizacion', 
    'acRequerimiento', 'acOficioReque', 'acConclusion', 'comentarios', 'numero'];
    public $timestamps = false;

    public function expediente(){
        return $this->belongsTo(Expediente::class, 'numero', 'numero');
    }
}
