<?php

namespace App\Livewire\Bienes;

use App\Models\Bien;
use Livewire\Component;

class RegistrosEliminados extends Component
{
    public function render()
    {

        $registrosEliminados = Bien::onlyTrashed()->get();

        return view('livewire.bienes.registros-eliminados', [
            'registrosEliminados' => $registrosEliminados,
        ]);
    }
}
