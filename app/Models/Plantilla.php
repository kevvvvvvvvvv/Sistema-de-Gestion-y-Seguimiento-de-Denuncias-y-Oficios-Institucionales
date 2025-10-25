<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plantilla extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'plantilla';
    protected $primaryKey = 'idPlantilla';
    protected $fillable = ['titulo', 'contenido'];
    protected $dates = ['deleted_at'];
    public $timestamps = false;
}
