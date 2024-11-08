<?php

namespace App\Livewire\Personal;

use App\Models\Movimiento;
use App\Models\Personal;
use Livewire\Component;

// class DetallePersonal extends Component
// {
//     public $personal;
//     public $movimientos = [];

//     public $showModalhistorial = false;
//     public $personalId;
//     public $personalNombre;
//     public $personalArea;

//     public function mount($id)
//     {
//         $this->personal = Personal::findOrFail($id);
//     }


//     public function render()
//     {
//         return view('livewire.personal.detalle-personal');
//     }

    

//     public function openModalhistorial($personalId)
//     {
//         $this->personalId = $personalId;
//         $this->showModalhistorial = true;

//         // Cargar el historial de movimientos del personal con el ID $personalId
//         $this->movimientos = Movimiento::where('personal_id', $personalId)
//             ->orderBy('created_at', 'desc')
//             ->get();
//     }

//     // Método para cerrar el modal
//     public function closeModalhistorial()
//     {
//         $this->showModalhistorial = false;
//     }
// }
class DetallePersonal extends Component
{
    public $personal;
    public $search = '';
    //public $movimientos = [];

    public $showModalhistorial = false;
    public $personalId;
    public $personalNombre;
    public $personalArea;

    public function mount($id)
    {
        $this->personal = Personal::findOrFail($id);
    }


    public function render()
    {
        $listaPersonal = Personal::query()
            ->where('rfc', 'LIKE', '%' . $this->search . '%')
            ->orWhere('nombre', 'LIKE', '%' . $this->search . '%')
            ->orWhere('area', 'LIKE', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $movimientos = collect();
        if ($this->showModalhistorial && $this->personalId) {
            $movimientos = Movimiento::where('personal_id', $this->personalId)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('livewire.personal.detalle-personal', compact('listaPersonal', 'movimientos'));
    }

    public function openModalhistorial($personalId)
    {
        $personal = Personal::findOrFail($personalId);
        $this->personalId = $personalId;
        $this->personalNombre = $personal->nombre;
        $this->personalArea = $personal->area;
        $this->showModalhistorial = true;
    }

    // Método para cerrar el modal
    public function closeModalhistorial()
    {
        $this->showModalhistorial = false;
    }
}