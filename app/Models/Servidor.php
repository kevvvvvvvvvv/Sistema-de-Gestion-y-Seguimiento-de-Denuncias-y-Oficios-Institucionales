<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity; 
use Spatie\Activitylog\LogOptions;

class Servidor extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'servidor';
    protected $primaryKey = 'idServidor';
    protected $fillable = ['nombreCompleto', 'genero', 'grado', 'fechaIngreso',
        'puesto', 'nivel', 'correo', 'telefono', 'estatus', 'descripcion','idInstitucion', 'idDepartamento'];
    public $timestamps = false;

    public function institucion(){
        return $this->belongsTo(Institucion::class, 'idInstitucion', 'idInstitucion')->withTrashed();
    }

    public function departamento(){
        return $this->belongsTo(Departamento::class, 'idDepartamento', 'idDepartamento')->withTrashed();
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
                return "Se ha {$accion} un servidor";
            })
            ->useLogName('default');
    }
}
