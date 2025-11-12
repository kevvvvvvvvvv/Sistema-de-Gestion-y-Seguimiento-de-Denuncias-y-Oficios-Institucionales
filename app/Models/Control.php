<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity; 
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Control extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'control';
    protected $primaryKey = 'consecutivo';
    protected $fillable = ['acProrroga', 'acAuxilio', 'acRegularizacion', 
    'acRequerimiento', 'acOficioReque', 'acInicio', 'acModificacion', 'acConclusion', 
    'feEntregaInicio', 'feEntregaModif', 'feEntregaCon', 'comentarios', 'numero'];
    protected $dates = ['deleted_at'];
    public $timestamps = false;

    public function expediente(){
        return $this->belongsTo(Expediente::class, 'numero', 'numero')->withTrashed();
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
