<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institucion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'institucion';
    protected $primaryKey = 'idInstitucion';
    protected $fillable = ['nombreCompleto', 'siglas'];
    protected $dates = ['deleted_at'];
    public $timestamps = false;

}
