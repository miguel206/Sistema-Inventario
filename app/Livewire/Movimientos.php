<?php

namespace App\Livewire;

use App\Models\Bien;
use App\Models\Movimiento;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Movimientos extends Component
{
    use WithPagination;
    public $search = '';
    public $opcionSeleccionada = ''; // Establecer un valor por defecto
    public $paginateDinamico = 10;

    // Habilitar la sincronización de 'search' con la URL
    protected $queryString = ['search' => ['except' => '']];

    #[On('movimientoAgregado')]
    public function render()
    {
        //$movimientosListas = Movimiento::orderBy('created_at', 'desc')->paginate(10);
        $movimientosListas = Movimiento::query()
            ->where('folio', 'LIKE', '%' . $this->search . '%')
            ->orWhere('tipo_moviento', 'LIKE', '%' . $this->search . '%')
            ->orWhere('fecha', 'LIKE', '%' . $this->search . '%')
            ->orWhere('observaciones', 'LIKE', '%' . $this->search . '%')
            ->orWhereHas('bien', function ($query) {
                $query->where('numero_inventario', 'LIKE', '%' . $this->search . '%');
            })
            ->orWhereHas('personal', function ($query) {
                $query->where('nombre', 'LIKE', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->paginateDinamico);

        return view('livewire.movimientos', compact('movimientosListas'));
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
    public $bienesInfo = [];
    public $tipoMovimiento;
    public $datosJSON;

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


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // JSON DE BIEN EDIT
    /////////////////////////////////////////////////////////////////////////////////////////////////////////

    public $showModalJSON = false;

    public function openModalJSON($movimientoId)
    {
        $movimiento = Movimiento::findOrFail($movimientoId);
        if ($movimiento && $movimiento->tipo_moviento === 'ACTUALIZACION') {
            $this->datosJSON = json_decode($movimiento->datosJSON, true);
        } else {
            $this->datosJSON = null;
        }

        $this->showModalJSON = true;
    }

    public function closeModalJSON()
    {
        $this->showModalJSON = false;
        $this->datosJSON = null;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // JSON DE ALTA DE BIENES
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    public $showBienModalJson = false;

    public function openBienModalJson($movimientoId)
    {
        //    dd($movimientoId);

        $movimiento = Movimiento::findOrFail($movimientoId);

        // // Extraer y decodificar el JSON en un array
        $this->bienInfo = json_decode($movimiento->datosJSON, true);

        // // Depurar con dd()
        // dd($this->bienInfo);
        Log::info('Contenido de bienInfo:', $this->bienInfo);

        $this->showBienModalJson = true;
    }

    public function closeBienModalJson()
    {
        $this->showBienModalJson = false;
    }
}
