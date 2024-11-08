<?php

namespace App\Livewire\Personal;

use App\Models\Bien;
use App\Models\Personal;
use App\Models\Movimiento;
use Livewire\Component;
use Livewire\WithPagination;

class ListaPersonal extends Component
{
    use WithPagination;
    public $search = '';

    public $showModalhistorial = false;
    public $personalId;

    public $personalNombre;
    public $personalArea;

    public $paginateDinamico = 10;

    // Habilitar la sincronización de 'search' con la URL
    protected $queryString = ['search' => ['except' => '']];

    public function render()
    {
        $listaPersonal = Personal::query()
            ->where('rfc', 'LIKE', '%' . $this->search . '%')
            ->orWhere('nombre', 'LIKE', '%' . $this->search . '%')
            ->orWhere('area', 'LIKE', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->paginateDinamico);

        $movimientos = collect();
        if ($this->showModalhistorial && $this->personalId) {
            $movimientos = Movimiento::where('personal_id', $this->personalId)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('livewire.personal.lista-personal', compact('listaPersonal', 'movimientos'));
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

    //====================================================================================================================
    // modal edicion 
    //====================================================================================================================
    public $openEdicion = false;
    public $workers = [];
    public $selectedWorkerId;
    public $selectedWorker;

    public function openEdicionPersonal($personalId)
    {
        $this->selectedWorkerId = $personalId;
        $this->selectedWorker = Personal::find($personalId);
        $this->workers = [
            'rfc' => $this->selectedWorker->rfc,
            'nombre' => $this->selectedWorker->nombre,
            'area' => $this->selectedWorker->area,
        ];
        $this->openEdicion = true;
    }


    // Método para cerrar el modal
    public function closeEdicionPersonal()
    {
        $this->openEdicion = false;
        $this->reset(['workers', 'selectedWorker']);
    }

    // Método para actualizar el personal
    public function updatePersonal()
    {
        // $this->validate([
        //     'workers.rfc' => 'required|string|max:13',
        //     'workers.nombre' => 'required|string|max:255',
        //     'workers.area' => 'required|string|max:255',
        // ]);

        if (empty($this->workers['rfc'])) {
            $this->handleValidationError('RFC');
            return;
        }

        if (empty($this->workers['nombre'])) {
            $this->handleValidationError('Nombre completo');
            return;
        }

        if (empty($this->workers['area'])) {
            $this->handleValidationError('Área');
            return;
        }

        $personal = Personal::find($this->selectedWorkerId);
        $personal->rfc = $this->workers['rfc'];
        $personal->nombre = $this->workers['nombre'];
        $personal->area = $this->workers['area'];
        $personal->save();

        session()->flash('success', 'Personal actualizado exitosamente');
        // Llamar a la función para crear el movimiento de Update
        $this->crearMovimientoACTUALIZACION($personal);

        session()->flash('success', 'Personal actualizado exitosamente.');
        $this->dispatch('swal', [
            'title' => 'Correcto!',
            'text' => 'Personal actualizado exitosamente!',
            'icon' => 'success',
        ]);

        $this->closeEdicionPersonal();
    }

    // Método para manejar errores de validación
    private function handleValidationError($field)
    {
        session()->flash('error', "El campo $field no puede estar vacío.");
        $this->dispatch('swal', [
            'title' => 'Error!',
            'text' => "El campo $field no puede estar vacío.",
            'icon' => 'error',
        ]);
    }

    // Función para crear el movimiento de alta
    private function crearMovimientoACTUALIZACION($personal)
    {
        // Crear un nuevo registro en la tabla de movimientos
        $movimiento = new Movimiento();
        //$movimiento->folio = 'ALTA_' . uniqid(); // Puedes usar un folio único para el movimiento de alta
        $movimiento->folio = 'ACTU_' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $movimiento->tipo_moviento = 'ACTUALIZACION';
        $movimiento->fecha = now(); // O puedes usar la fecha actual
        $movimiento->estado = 'N/A';
        $movimiento->observaciones = 'Se actualizaron los datos de ' . $personal->nombre;
        $movimiento->personal_id = $personal->id; // Establece el ID del bien asociado al movimiento de alta

        $movimiento->save();
    }

    //====================================================================================================================
    // modal baja 
    //====================================================================================================================
    public $openBaja = false;
    // public $selectedWorkerId;
    //public $selectedWorker;

    public function openBajaPersonal($personalId)
    {
        $this->selectedWorkerId = $personalId;
        $this->selectedWorker = Personal::find($personalId);
        $this->openBaja = true;
    }

    //Método para cerrar el modal de baja
    public function closeBajaPersonal()
    {
        $this->openBaja = false;
    }
    //====================================================================================================================
    // bienes historial
    //====================================================================================================================
    public $historial = false;
    public $historialBienes = [];
    // En tu componente Livewire
    // public function obtenerMovimientosPorFolio($personalId)
    // {
    //     if (!$personalId) {
    //         $this->dispatch('swal', [
    //             'title' => 'Advertencia',
    //             'text' => 'Debe seleccionar un empleado.',
    //             'icon' => 'warning',
    //         ]);
    //         return;
    //     }

    //     // Obtener todos los movimientos asociados al personal seleccionado
    //     $movimientos = Movimiento::where('personal_id', $personalId)
    //         ->whereIn('tipo_moviento', ['RESGUARDO', 'DEVOLUCION'])
    //         //->whereIn('estado', ['COMPLETO', 'PARCIAL', 'N/A'])
    //         ->orderBy('fecha', 'desc') // Ordenar por fecha más reciente
    //         ->get();

    //     $historial = collect();

    //     foreach ($movimientos as $movimiento) {
    //         // Obtener los bienes asociados a cada movimiento
    //         $bienes = $movimiento->bienes()->withPivot('deleted_at')->get();
    //         foreach ($bienes as $bien) {
    //             $historial->push([
    //                 'folio' => $movimiento->folio,
    //                 'fecha' => $movimiento->fecha,
    //                 'numero_inventario' => $bien->numero_inventario,
    //                 'numero_serie' => $bien->numero_serie,
    //                 'descripcion' => $bien->descripcion,
    //                 'modelo' => $bien->modelo,
    //                 'marca' => $bien->marca,
    //                 'tipo_movimiento' => $movimiento->tipo_moviento,
    //                 'observaciones' => $movimiento->observaciones,
    //             ]);
    //         }
    //     }

    //     $this->historialBienes = $historial;
    //     $this->historial = true;
    // }
    public function obtenerHistorialBienes($personalId)
    {
        $this->personalId = $personalId;

        $personal = Personal::find($this->personalId);

        if (!$personal) {
            $this->dispatch('swal', [
                'title' => 'Advertencia',
                'text' => 'El personal seleccionado no existe.',
                'icon' => 'warning',
            ]);
            $this->historial = []; // Limpiar historial en caso de error
            return;
        }

        $this->historial = $personal->movimientosConBienes();
    }



    public function closeBienesResguistro()
    {
        $this->historial = false;
    }
}
