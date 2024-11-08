<?php

namespace App\Livewire\Crear;

use App\Models\Bien;
use App\Models\Movimiento;
use App\Models\Personal;
use Livewire\Component;

class Resguardo extends Component
{
    public $open = false;
    public $lista_personal;
    public $lista_bienes;
    public $fecha;
    public $observacion;

    public $selected_personal;
    public $selected_bienes = [];

    public function mount()
    {
        $this->lista_personal = Personal::all();
        $this->lista_bienes = Bien::all();
        $this->fecha = now()->toDateString();
    }

    public function render()
    {
        return view('livewire.crear.resguardo');
    }

    public function submit()
    {
        // Valida los campos necesarios
        $this->validate([
            'selected_personal' => 'required',
            'selected_bienes' => 'required|array|min:1',
            'fecha' => 'required|date',
            'observacion' => 'nullable',
        ]);

        // Crea una nueva instancia de Movimiento
        $movimiento = new Movimiento();

        // Establece los valores del movimiento
        $movimiento->folio = 'RESGUARDO_' . uniqid();
        $movimiento->tipo_moviento = 'RESGUARDO';
        $movimiento->fecha = $this->fecha;
        $movimiento->observaciones = $this->observacion;
        $movimiento->personal_id = $this->selected_personal;

        // Establece el bien_id como el primer bien seleccionado
        $movimiento->bien_id = $this->selected_bienes[0];

        // Guarda el movimiento en la base de datos
        $movimiento->save();

        // Reinicia los campos y cierra el modal
        $this->reset(['selected_personal', 'selected_bienes', 'observacion', 'fecha', 'open']);

        // Muestra un mensaje de éxito
        session()->flash('success', 'Resguardo creado exitosamente');
    }
}
