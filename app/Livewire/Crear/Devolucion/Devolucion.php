<?php

namespace App\Livewire\Crear\Devolucion;

use App\Models\Bien;
use App\Models\Movimiento;
use App\Models\Personal;
use Livewire\Component;

class Devolucion extends Component
{
    public $open = false;

    public $fecha;
    public $observacion;

    public $lista_personal;

    public $terminoBusquedaPersonals = '';
    public $selected_personal;
    public $selected_bienes = [];

    public $perPage = 1;

    public $bienes_asociados; // Declaración de la propiedad


    public function mount()
    {
        $this->fecha = now()->toDateString();
    }

    public function render()
    {
        $personal = Personal::where('nombre', 'like', '%' . $this->terminoBusquedaPersonals . '%')->paginate($this->perPage);

        return view('livewire.crear.devolucion.devolucion', [
            'personal' => $personal
        ]);
    }

    public function clearSelection()
    {
        $this->selected_personal = null;
        //$this->selected_bienes = [];
    }


    // public function selectPersonal($id)
    // {
    //     $this->selected_personal = Personal::findOrFail($id);
    //     $this->terminoBusquedaPersonals = '';

    //     // Obtener los movimientos del personal seleccionado
    //     $movimientos = $this->selected_personal->movimientos;

    //     // Inicializar un array para almacenar los bienes asociados al personal
    //     $bienes_asociados = [];

    //     // Recorrer los movimientos y obtener los bienes asociados
    //     foreach ($movimientos as $movimiento) {
    //         // Verificar si el bien está asignado al personal actual
    //         if ($movimiento->bien && $movimiento->bien->personal_id == $id) {
    //             $bienes_asociados[] = $movimiento->bien;
    //         }
    //     }

    //     // Asignar los bienes asociados al personal a la propiedad correspondiente
    //     $this->bienes_asociados = $bienes_asociados;
    // }

    public function selectPersonal($id)
    {
        $this->selected_personal = Personal::findOrFail($id);
        $this->terminoBusquedaPersonals = '';

        // Obtener los movimientos del personal seleccionado
        $movimientos = $this->selected_personal->movimientos;

        // Inicializar un array para almacenar los bienes asociados al personal
        $bienes_asociados = [];

        // Recorrer los movimientos y obtener los bienes asociados
        foreach ($movimientos as $movimiento) {
            // Obtener los bienes asociados al movimiento
            $bienes = $movimiento->bien;

            // Recorrer los bienes asociados y verificar si están asignados al personal actual
            foreach ($bienes as $bien) {
                if ($bien->personal_id == $id) {
                    $bienes_asociados[] = $bien;
                }
            }
        }

        // Asignar los bienes asociados al personal a la propiedad correspondiente
        $this->bienes_asociados = $bienes_asociados;
    }



    // public function devolverBienes()
    // {
    //     // Validar si se ha seleccionado un personal y al menos un bien para devolver
    //     if (!$this->selected_personal || empty($this->selected_bienes)) {
    //         $this->addError('devolucion', 'Debe seleccionar un miembro del personal y al menos un bien para devolver.');
    //         return;
    //     }

    //     // Asignar los bienes al movimiento
    //     foreach ($this->selected_bienes as $bienId) {
    //         // Crear una nueva instancia del modelo de Movimiento
    //         $movimiento = new Movimiento();

    //         // Asignar los valores de los campos correspondientes
    //         $movimiento->folio = 'DEVO_' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    //         $movimiento->tipo_moviento = 'DEVOLUCION';
    //         $movimiento->fecha = $this->fecha;
    //         $movimiento->observaciones = $this->observacion;
    //         $movimiento->personal_id = $this->selected_personal->id;

    //         $bien = Bien::findOrFail($bienId);
    //         $movimiento->bien()->associate($bien);

    //         // Guardar el movimiento en la base de datos
    //         $movimiento->save();

    //         // Cambiar el estado del bien a "DISPONIBLE" y quitar la asociación con el personal actual
    //         $bien->estado = 'DISPONIBLE';
    //         $bien->personal_id = null;
    //         $bien->save();
    //     }

    //     // Disparamos el evento 'bienAgregado'
    //     $this->dispatch('movimientoAgregado');
    //     $this->dispatch('swal', [
    //         'title' => 'Correcto!',
    //         'text' => 'devolucion exitosa!',
    //         'icon' => 'success',
    //     ]);

    //     // Limpiar los campos después de la devolución de bienes
    //     $this->selected_personal = null;
    //     $this->selected_bienes = [];
    //     $this->observacion = '';
    //     $this->fecha = now()->toDateString();
    //     $this->open = false;

    //     // Mostrar un mensaje de éxito
    //     session()->flash('message', 'La devolución de bienes se ha procesado correctamente.');
    // }

    public function devolverBienes()
    {
        // Validar si se ha seleccionado un personal y al menos un bien para devolver
        if (!$this->selected_personal || empty($this->selected_bienes)) {
            $this->addError('devolucion', 'Debe seleccionar un miembro del personal y al menos un bien para devolver.');
            return;
        }

        // Crear una nueva instancia del modelo de Movimiento
        $movimiento = new Movimiento();

        // Asignar los valores de los campos correspondientes
        $movimiento->folio = 'DEVO_' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $movimiento->tipo_moviento = 'DEVOLUCION';
        $movimiento->fecha = $this->fecha;
        $movimiento->observaciones = $this->observacion;
        $movimiento->personal_id = $this->selected_personal->id;

        // Obtener el folio del resguardo asociado a los bienes seleccionados
        $folioResguardo = $this->obtenerIdFolioResguardo();

        // Obtener la cantidad total original de bienes del folio del resguardo
        $cantidadTotalBienes = $folioResguardo->cantidad;

        // Contar la cantidad total de bienes devueltos
        $cantidadBienesDevueltos = count($this->selected_bienes);

        // Restar la cantidad de bienes devueltos a la cantidad total del folio del resguardo
        $cantidadRestante = $cantidadTotalBienes - $cantidadBienesDevueltos;

        // Actualizar la cantidad restante en el folio del resguardo
        $folioResguardo->cantidad = $cantidadRestante;
        $folioResguardo->save();

        // Guardar la cantidad de bienes devueltos en la columna 'cantidad' del movimiento
        $movimiento->cantidad = $cantidadBienesDevueltos;

        // Si la cantidad restante es menor que la cantidad total original del folio, cambiar el estado del folio a "PARCIAL"
        if ($cantidadRestante < $cantidadTotalBienes) {
            $folioResguardo->estado = 'PARCIAL';
            $folioResguardo->save();
        }

        // Guardar el movimiento en la base de datos
        $movimiento->save();

        // Asociar los bienes al movimiento en la tabla pivote y actualizar su estado y asociación con el personal
        $this->asociarBienAMovimiento($movimiento);

        // Disparamos el evento 'movimientoAgregado'
        $this->dispatch('movimientoAgregado');
        $this->dispatch('swal', [
            'title' => 'Correcto!',
            'text' => 'devolucion exitosa!',
            'icon' => 'success',
        ]);

        // Limpiar los campos después de la devolución de bienes
        $this->selected_personal = null;
        $this->selected_bienes = [];
        $this->observacion = '';
        $this->fecha = now()->toDateString();
        $this->open = false;

        // Mostrar un mensaje de éxito
        session()->flash('message', 'La devolución de bienes se ha procesado correctamente.');
    }

    private function obtenerIdFolioResguardo()
    {
        // Obtener el ID del folio del resguardo asociado a uno de los bienes seleccionados
        $bienId = $this->selected_bienes[0]; // Suponiendo que todos los bienes seleccionados tienen el mismo folio de resguardo
        $idFolioResguardo = Movimiento::whereHas('bien', function ($query) use ($bienId) {
            $query->where('id', $bienId);
        })
            ->where('tipo_moviento', 'RESGUARDO')
            ->latest()
            ->value('id');

        return $idFolioResguardo;
    }




    private function asociarBienAMovimiento($movimiento)
    {

        // // Asociar el bien al movimiento en la tabla pivote
        // $movimiento->bien()->attach($movimiento->id); // Ajusta el personal_id según sea necesario
        // Obtener los IDs de los bienes seleccionados
        $bienesIds = $this->selected_bienes;

        // Asociar cada bien al movimiento en la tabla pivote
        foreach ($bienesIds as $bienId) {
            $movimiento->bien()->attach($bienId);
            $bien = Bien::findOrFail($bienId);
            // Cambiar el estado del bien a "DISPONIBLE" y quitar la asociación con el personal actual
            $bien->estado = 'DISPONIBLE';
            $bien->personal_id = null;
            $bien->save();
        }
    }
}
