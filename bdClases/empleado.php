<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $table = 'emplleados';
    public $incrementing = true;
    public $timestamps = false;

    const DELETED_AT = 'fecha_de_baja';

    protected $fillable = [
        'nombre', 'apellido', 'mail', 'clave', 'puesto'
    ];
}
?>