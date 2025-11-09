<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity; 
use Spatie\Activitylog\LogOptions;

class Control extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'control';
    protected $primaryKey = 'consecutivo';
    protected $fillable = ['acProrroga', 'acAuxilio', 'acRegularizacion', 
    'acRequerimiento', 'acOficioReque', 'acInicio', 'acModificacion', 'acConclusion', 
    'feEntregaInicio', 'feEntregaModif', 'feEntregaCon', 'comentarios', 'numero'];
    public $timestamps = false;

    public function expediente(){
        return $this->belongsTo(Expediente::class, 'numero', 'numero');
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
                return "Se ha {$accion} un control";
            })
            ->useLogName('default');
    }

}
