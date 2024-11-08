<?php

namespace App\Livewire\Movimientos;

use App\Models\Bien;
use App\Models\Movimiento;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Resguardo extends Component
{
    use WithPagination;

    public $search = '';
    public $opcionSeleccionada = '';
    public $paginateDinamico = 10;

    // Habilitar la sincronización de 'search' con la URL
    protected $queryString = ['search' => ['except' => '']];

    #[On('movimientoAgregado')]
    public function render()
    {
        $movimientosListas = Movimiento::query()
            ->where('tipo_moviento', 'RESGUARDO')
            ->where(function ($query) {
                $query->where('folio', 'like', '%' . $this->search . '%')
                    ->orWhere('fecha', 'like', '%' . $this->search . '%')
                    ->orWhereHas('personal', function ($query) {
                        $query->where('nombre', 'like', '%' . $this->search . '%')
                            ->orWhere('area', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('estado', 'like', '%' . $this->search . '%')
                    ->orWhere('observaciones', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->paginateDinamico);

        return view('livewire.movimientos.resguardo', compact('movimientosListas'));
    }

    public $showModalview = false;
    public $bienInfo;
    public $edit_id;

    public function openModalView($id)
    {
        // Establece el ID del bien que se está editando
        $this->edit_id = $id;
        // Buscar el bien en la base de datos por su ID
        $this->bienInfo = Bien::findOrFail($id);

        // Abrir el modal
        $this->showModalview = true;
        //dd($this->bien);

    }

    public function closeModalView()
    {
        $this->showModalview = false;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    public $showModalBienes = false;
    //public $bienesInfo;
    public $bienesInfo = [];



    public function openModalBienes($movimientoId)
    {
        // Buscar el movimiento con el ID de folio
        $movimiento = Movimiento::findOrFail($movimientoId);
        if ($movimiento) {
            $bienesIds = $movimiento->bien()->pluck('bien_id')->toArray();
            if (!empty($bienesIds)) {
                $this->bienesInfo = Bien::whereIn('id', $bienesIds)->get();
            } else {
                $this->bienesInfo = [];
            }
        } else {
            $this->bienesInfo = [];
        }

        // Abrir el modal
        $this->showModalBienes = true;
    }



    public function closeModalBienes()
    {
        // Abrir el modal
        $this->showModalBienes = false;
    }
}
