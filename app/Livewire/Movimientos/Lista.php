<?php

namespace App\Livewire\Movimientos;

use App\Models\Movimiento;
use Livewire\Component;

class Lista extends Component
{
    public function render()
    {
        // Obtener los movimientos agrupados por número de folio
        $movimientos = Movimiento::select('folio', 'tipo_moviento', 'fecha', 'observaciones','personal_id')
            ->groupBy('folio', 'tipo_moviento', 'fecha', 'observaciones','personal_id')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.movimientos.lista', compact('movimientos'));
    }
}
