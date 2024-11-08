<?php

namespace App\Livewire\Bienes;

use App\Models\Bien;
use Livewire\Component;
use Livewire\WithPagination;

class DetalleBien extends Component
{
    use WithPagination;

    public $bien;
    public $showModalhistorial = false;
    public $bienId;

    public function mount($id)
    {
        $this->bien = Bien::findOrFail($id);
    }

    public function openModalhistorial($bienId)
    {
        $this->bienId = $bienId;
        $this->showModalhistorial = true;
    }

    public function render()
    {
        $movimientos = collect();

        if ($this->showModalhistorial && $this->bienId) {
            $bien = Bien::findOrFail($this->bienId);
            $movimientos = $bien->todosLosMovimientos()
                ->orderBy('created_at', 'desc')
                ->paginate(10); // Paginar a 10 elementos por página
        }

        return view('livewire.bienes.detalle-bien', [
            'movimientos' => $movimientos
        ]);
    }

    public function closeModalhistorial()
    {
        $this->showModalhistorial = false;
    }
}
