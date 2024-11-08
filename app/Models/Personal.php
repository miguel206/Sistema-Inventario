<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'rfc',
        'nombre',
        'area',
    ];

    public function bienes()
    {
        return $this->hasMany(Bien::class); // Relación inversa con Bien
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    // Define el método para recuperar todos los movimientos con los bienes asociados
    public function movimientosConBienes()
    {
        // Recupera todos los movimientos asociados al personal con bienes, incluyendo soft-deleted, y los ordena por created_at en forma descendente
        $movimientos = $this->movimientos()
            ->with('bienes')
            ->orderBy('created_at', 'desc')
            ->get();

        // Crear una colección para el historial
        $historial = collect();

        foreach ($movimientos as $movimiento) {
            // Incluir los bienes asociados a cada movimiento, incluso si están soft-deleted
            foreach ($movimiento->bienes as $bien) {
                $historial->push([
                    'folio' => $movimiento->folio,
                    'fecha' => $movimiento->fecha,
                    'numero_inventario' => $bien->numero_inventario,
                    'numero_serie' => $bien->numero_serie,
                    'descripcion' => $bien->descripcion,
                    'modelo' => $bien->modelo,
                    'marca' => $bien->marca,
                    'tipo_movimiento' => $movimiento->tipo_moviento,
                    'observaciones' => $movimiento->observaciones,
                ]);
            }
        }

        return $historial;
    }
}
