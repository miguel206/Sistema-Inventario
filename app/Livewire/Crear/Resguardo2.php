<?php

namespace App\Livewire\Crear;

use App\Livewire\Movimientos;
use App\Models\Bien;
use App\Models\Movimiento;
use App\Models\Personal;
use Livewire\Component;
use Livewire\WithPagination;
use phpDocumentor\Reflection\Types\This;

class Resguardo2 extends Component
{
    use WithPagination;

    public $open = false;

    public $fecha;
    public $observacion;

    public $lista_personal;
    public $lista_bienes;

    public $terminoBusquedaPersonals = '';
    public $selected_personal;

    public $terminoBusquedaBienes = '';
    public $selected_bienes = [];

    // Define una propiedad para el número de elementos por página
    public $perPage = 1;
    public $perBien = 1;


    public function mount()
    {
        $this->fecha = now()->toDateString();
    }

    public function render()
    {
        $personal = Personal::where('nombre', 'like', '%' . $this->terminoBusquedaPersonals . '%')->paginate($this->perPage);

        $bienes = Bien::where(function ($query) {
            $query->where('descripcion', 'like', '%' . $this->terminoBusquedaBienes . '%')
                ->orWhere('numero_inventario', 'like', '%' . $this->terminoBusquedaBienes . '%')
                ->orWhere('numero_serie', 'like', '%' . $this->terminoBusquedaBienes . '%');
        })
            ->where('estado', 'DISPONIBLE')
            ->paginate($this->perPage);

        // Obtener la fecha de creación del bien más antiguo
        $fecha_minima = $bienes->min('created_at');

        // Formatear la fecha mínima en el formato adecuado para el campo de fecha
        $fecha_minima = date('Y-m-d', strtotime($fecha_minima));

        return view('livewire.crear.resguardo2', [
            'personal' => $personal,
            'bienes' => $bienes,
            'fecha_minima' => $fecha_minima, // Pasar la fecha mínima a la vista
        ]);
    }


    public function clearSelection()
    {
        $this->selected_personal = null;
    }

    public function selectPersonal($id)
    {
        $this->selected_personal = Personal::findOrFail($id);
        $this->terminoBusquedaPersonals = '';
    }

    public function selectBien($id)
    {
        // Verificar si el bien ya está seleccionado antes de agregarlo
        if (!in_array($id, $this->selected_bienes)) {
            $this->selected_bienes[] = $id;
            $this->terminoBusquedaBienes = ''; // Limpiar la búsqueda después de seleccionar un bien
        }
    }

    public function removeBien($index)
    {
        unset($this->selected_bienes[$index]);
    }

    public function submit()
    {
        // Validar si se ha seleccionado un empleado y al menos un bien
        if (!$this->selected_personal || empty($this->selected_bienes)) {
            $this->addError('submit', 'Debe seleccionar un empleado y al menos un bien.');
            return;
        }

        // Generar un número de folio único para el conjunto de movimientos
        $folio = 'RESG_' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Crear una nueva instancia del modelo de Movimiento
        $movimiento = new Movimiento();
        // Asignar los valores de los campos correspondientes
        $movimiento->folio = $folio;
        $movimiento->tipo_moviento = 'RESGUARDO';
        $movimiento->fecha = $this->fecha;
        $movimiento->observaciones = $this->observacion;
        $movimiento->personal_id = $this->selected_personal->id;
        // Contar la cantidad total de bienes seleccionados
        $cantidadTotalBienes = count($this->selected_bienes);

        // Guardar la cantidad total de bienes en la columna 'cantidad'
        $movimiento->cantidad = $cantidadTotalBienes;
        $movimiento->estado = 'COMPLETO';
        // Guardar el movimiento en la base de datos
        $movimiento->save();

        // Asociar los bienes al movimiento en la tabla pivote
        $this->asociarBienAMovimiento($movimiento);

        // Disparamos el evento 'bienAgregado'
        $this->dispatch('movimientoAgregado');
        $this->dispatch('swal', [
            'title' => 'Correcto!',
            'text' => 'resguardo agregado exitosamente!',
            'icon' => 'success',
        ]);

        // Limpiar los campos después de guardar el movimiento
        $this->selected_personal = null;
        $this->selected_bienes = [];
        $this->observacion = '';
        $this->fecha = now()->toDateString();
        $this->open = false;

        // Mostrar un mensaje de éxito
        session()->flash('message', 'El resguardo se ha guardado correctamente.');
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
            $bien->estado = 'RESGUARDO';
            $bien->personal_id = $this->selected_personal->id; // Asignar el personal seleccionado al bien
            $bien->save();
        }
    }
}
