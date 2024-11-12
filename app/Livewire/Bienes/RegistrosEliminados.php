<?php

namespace App\Livewire\Bienes;

use App\Models\Bien;
use Livewire\Component;

class RegistrosEliminados extends Component
{
    public $search = '';      // Término de búsqueda
    public $filterDate;       // Fecha para filtrar

    public function render()
    {
        // Filtrar los registros eliminados por búsqueda y fecha de baja
        $registrosEliminados = Bien::onlyTrashed()
        

            ->when($this->search, function ($query) {
                $query->where('descripcion', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterDate, function ($query) {
                $query->whereDate('fecha_baja', $this->filterDate);
            })
            ->get();

        return view('livewire.bienes.registros-eliminados', [
            'registrosEliminados' => $registrosEliminados,
        ]);
    }
}