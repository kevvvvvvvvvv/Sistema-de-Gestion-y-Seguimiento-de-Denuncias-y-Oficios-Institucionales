<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity; 
use Spatie\Activitylog\LogOptions;

class Baja extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'baja';
    protected $primaryKey = 'idBaja';
    protected $fillable = ['puestoAnt', 'nivelAnt', 'adscripcionAnt', 
    'fechaIngresoAnt', 'fechaBaja', 'descripcion','numero', 'idServidor'];
    public $timestamps = false;

    public function expediente(){
        return $this->belongsTo(Expediente::class, 'numero', 'numero')->withTrashed();
    }

    public function servidor(){
        return $this->belongsTo(Servidor::class, 'idServidor', 'idServidor');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty() 
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->setDescriptionForEvent(function (string $eventName) {
                $accion = match ($eventName) {
                    'created' => 'creado',
                    'updated' => 'actualizado',
                    'deleted' => 'eliminado',
                    'restored' => 'restaurado',
                    default => $eventName,
                };
                return "Se ha {$accion} una baja";
            })
            ->useLogName('default');
    }
}
