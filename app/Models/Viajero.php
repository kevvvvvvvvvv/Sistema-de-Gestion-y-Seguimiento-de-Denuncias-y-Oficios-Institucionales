<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity; 
use Spatie\Activitylog\LogOptions;

class Viajero extends Model
{
    use LogsActivity;

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
                return "Se ha {$accion} un viajero";
            })
            ->useLogName('default');
    }
}
