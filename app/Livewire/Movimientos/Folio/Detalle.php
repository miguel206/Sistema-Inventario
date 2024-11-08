<?php

namespace App\Livewire\Movimientos\Folio;

use App\Models\Movimiento;
use Livewire\Component;

class Detalle extends Component
{
    public $movimientoId;

    public function mount($id)
    {
        $this->movimientoId = $id;
    }

    public function render()
    {
        // $movimiento = Movimiento::findOrFail($this->movimientoId);

        // return view('livewire.movimientos.folio.detalle', compact('movimiento'));
        // Obtener el movimiento con sus bienes y los bienes devueltos
        $movimiento = Movimiento::with(['bien', 'bienDevueltos'])->findOrFail($this->movimientoId);

        return view('livewire.movimientos.folio.detalle', compact('movimiento'));
    }
}
