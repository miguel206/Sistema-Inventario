<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimiento extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'folio',
        'tipo_moviento',
        'fecha',
        'observaciones',
        'bien_id',
        'personal_id',
        'estado',
        'cantidad',
        'datosJSON',
        'fecha_termino'
    ];

    public function bien()
    {
        return $this->belongsToMany(Bien::class, 'movimiento_bien', 'movimiento_id', 'bien_id')
            ->withTimestamps()
            ->withPivot('deleted_at')
            ->wherePivot('deleted_at', null);
    }

    ////////////////////////////////////////////////////////////////////////////////
    // relacion del el componentetablaPrestamo
    public function PrestamoTable()
    {
        return $this->belongsToMany(Bien::class, 'movimiento_bien', 'movimiento_id', 'bien_id')
            ->withTimestamps()
            ->withPivot('devuelto','deleted_at')
            ->withTrashed();
    }
    

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }

    public function bienDevueltos()
    {
        return $this->belongsToMany(Bien::class, 'movimiento_bien', 'movimiento_id', 'bien_id')
            ->withPivot('deleted_at')
            ->withTimestamps()
            ->wherePivotNotNull('deleted_at');
    }

    public function bienes()
    {
        return $this->belongsToMany(Bien::class, 'movimiento_bien', 'movimiento_id', 'bien_id')
            ->withTimestamps()
            ->withPivot('deleted_at')
            ->withTrashed(); // Incluir los registros eliminados suavemente
    }
}
