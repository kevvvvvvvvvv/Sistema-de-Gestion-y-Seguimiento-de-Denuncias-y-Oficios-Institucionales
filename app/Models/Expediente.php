<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity; 
use Spatie\Activitylog\LogOptions;

class Expediente extends Model
{
    use HasFactory;
     use LogsActivity;

    protected $table = 'expediente';

    protected $primaryKey = 'numero';
    public $incrementing = false;
    protected $keyType = 'string'; 
    protected $fillable = ['numero', 'ofRequerimiento', 'fechaRequerimiento', 'ofRespuesta', 
    'fechaRespuesta', 'fechaRecepcion', 'idServidor'];
    public $timestamps = false;

    public function servidor(){
        return $this->belongsTo(Servidor::class, 'idServidor', 'idServidor');
    }

    public function control()
    {
        return $this->hasOne(Control::class, 'numero', 'numero');
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
                return "Se ha {$accion} un expediente";
            })
            ->useLogName('default');
    }
}
