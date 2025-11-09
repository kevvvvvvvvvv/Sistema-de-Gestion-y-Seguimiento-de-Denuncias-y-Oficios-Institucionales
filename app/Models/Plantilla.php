<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity; 
use Spatie\Activitylog\LogOptions;

class Plantilla extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'plantilla';
    protected $primaryKey = 'idPlantilla';
    protected $fillable = ['titulo', 'contenido'];
    public $timestamps = false;

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
                return "Se ha {$accion} una plantilla";
            })
            ->useLogName('default');
    }
}
