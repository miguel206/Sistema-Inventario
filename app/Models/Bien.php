<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bien extends Model
{
    use HasFactory;

    use SoftDeletes;


    protected $fillable = [
        'numero_inventario',
        'numero_serie',
        'descripcion',
        'modelo',
        'marca',
        'precio',
        'factura',
        'observaciones',
        'estado',
        'fecha_baja',
        'fecha_ingreso',
        'documento',
    ];

    public function personal()
    {
        return $this->belongsTo(Personal::class); // Relación inversa con Personal
    }

   

    public function movimientos()
    {
        return $this->belongsToMany(Movimiento::class, 'movimiento_bien', 'bien_id', 'movimiento_id')
            ->withTimestamps()
            ->withPivot('deleted_at')
            ->wherePivot('deleted_at', null);
    }

    public function movimientosResguardo()
    {
        return $this->belongsToMany(Movimiento::class, 'movimiento_bien', 'bien_id', 'movimiento_id')
            ->where('tipo_moviento', 'RESGUARDO')
            ->whereIn('estado', ['COMPLETO', 'PARCIAL'])
            ->withPivot('deleted_at')
            ->wherePivot('deleted_at', null);
    }

    public function todosLosMovimientos()
    {
        // return $this->belongsToMany(Movimiento::class, 'movimiento_bien', 'bien_id', 'movimiento_id')
        //     ->withTimestamps()
        //     ->withPivot('deleted_at')
        //     ->withTrashed(); // Incluir los registros eliminados suavemente
        return $this->belongsToMany(Movimiento::class, 'movimiento_bien', 'bien_id', 'movimiento_id')
            ->withTimestamps()
            ->withPivot('deleted_at')
            ->withTrashed(); // Incluir los registros eliminados suavemente
    }
}
