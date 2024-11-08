<?php

namespace App\Livewire\Personal;

use App\Models\Folio;
use App\Models\Movimiento;
use App\Models\Personal;
use Livewire\Attributes\On;
use Livewire\Component;

class CrearDinamicoInterno extends Component
{
    public $open = false;
    public $workers = [];
    public $fecha_ingreso;

    public function render()
    {
        return view('livewire.personal.crear-dinamico-interno');
    }

    public function abrirModal()
    {
        $this->open = true;
        $this->addBien();
    }

    public function mount()
    {
        $this->workers = [];
        $this->fecha_ingreso = now()->toDateString();
    }

    public function addBien()
    {
        $this->workers[] = [
            'rfc' => '',
            'nombre' => '',
            'area' => '',
        ];
    }

    protected $rules = [
        'workers.*.rfc' => 'required|string|max:13',
        'fecha_ingreso' => 'required|date',
        'workers.*.nombre' => 'required|string|max:255',
        'workers.*.area' => 'required|string|in:Presidencia,Secretaria Ejecutiva,Secretaría Administrativa,Dirección Ejecutiva de Asociaciones Políticas,Dirección Ejecutiva de Organización Electoral,Dirección Ejecutiva de Educación Cívica y Capacitación,Dirección Ejecutiva Jurídica y de lo Contencioso,Dirección Ejecutiva de Participación Ciudadana,Unidad Técnica de Planeación,Unidad Técnica del Servicio Profesional Electoral,Unidad de Transparencia,Unidad Técnica de Comunicación Social,Unidad Técnica de Oficialía Electoral,Unidad Técnica de Servicios Informáticos,Unidad Técnica de Género y No Discriminación,Unidad Técnica de Asuntos Indígenas,Unidad Técnica de Vinculación con el INE,otro',
        'workers.*.area_especifica' => 'required_if:workers.*.area,otro|string|max:255', // Validación condicional
    ];


    protected $messages = [
        'workers.*.rfc.required' => 'RFC es obligatoria.',
        'workers.*.rfc.string' => 'El RFC debe ser una cadena de texto.',
        'workers.*.rfc.max' => 'El RFC no puede tener más de 13 caracteres.',

        'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
        'fecha_ingreso.date' => 'La fecha de ingreso debe ser una fecha válida.',
        'workers.*.nombre.required' => 'El nombre completo es obligatorio.',
        'workers.*.nombre.string' => 'El nombre completo debe ser una cadena de texto.',
        'workers.*.nombre.max' => 'El nombre completo no puede tener más de 255 caracteres.',
        'workers.*.area.required' => 'El área es obligatoria.',
        'workers.*.area.string' => 'El área debe ser una cadena de texto.',
        'workers.*.area.in' => 'El área seleccionada no es válida.',
    ];


    public function removeBien($index)
    {
        unset($this->workers[$index]);
        $this->workers = array_values($this->workers);
    }


    // #[On('go-submit-Registro')]
    // public function submit()
    // {
    //     $this->validate();

    //     // Guardar la cantidad de bienes agregados
    //     $cantidadworkers = count($this->workers);

    //     // // Crear un nuevo folio
    //     // $folio = $this->crearFolio($cantidadworkers);

    //     // Recorremos todos los bienes y los guardamos en la base de datos
    //     foreach ($this->workers as $worker) {
    //         $nuevoworker = new Personal();
    //         $nuevoworker->rfc = $worker['rfc'];
    //         $nuevoworker->nombre = $worker['nombre'];
    //         $nuevoworker->area = $worker['area'];
    //         $nuevoworker->fecha_ingreso = $this->fecha_ingreso;
    //         $nuevoworker->save();

    //         // Llamar a la función para crear el movimiento de alta
    //         $this->crearMovimientoAlta($nuevoworker);
    //     }

    //     // Reiniciamos el array de bienes
    //     $this->workers = [];

    //     // Limpiamos los campos del formulario
    //     $this->reset();

    //     // Mostramos el mensaje de éxito
    //     session()->flash('success', 'Bienes añadidos al inventario exitosamente');

    //     // Disparamos el evento 'bienAgregado'
    //     $this->dispatch('movimientoAgregado');
    //     $this->dispatch('personalAgregado');
    //     $this->dispatch('swal', [
    //         'title' => 'Correcto!',
    //         'text' => 'personal agregado exitosamente!',
    //         'icon' => 'success',
    //     ]);
    // }


    // public function submit()
    // {
    //     try {


    //         $this->validate();


    //         // Guardar la cantidad de bienes agregados
    //         $cantidadworkers = count($this->workers);

    //         // // Crear un nuevo folio
    //         // $folio = $this->crearFolio($cantidadworkers);

    //         // Recorremos todos los bienes y los guardamos en la base de datos
    //         foreach ($this->workers as $worker) {
    //             $nuevoworker = new Personal();
    //             $nuevoworker->rfc = $worker['rfc'];
    //             $nuevoworker->nombre = $worker['nombre'];
    //             $nuevoworker->area = $worker['area'];
    //             $nuevoworker->fecha_ingreso = $this->fecha_ingreso;
    //             $nuevoworker->save();

    //             // Llamar a la función para crear el movimiento de alta
    //             $this->crearMovimientoAlta($nuevoworker);
    //         }

    //         // Reiniciamos el array de bienes
    //         $this->workers = [];

    //         // Limpiamos los campos del formulario
    //         $this->reset();

    //         // Mostramos el mensaje de éxito
    //         session()->flash('success', 'Bienes añadidos al inventario exitosamente');

    //         // Disparamos el evento 'bienAgregado'
    //         $this->dispatch('movimientoAgregado');
    //         $this->dispatch('personalAgregado');
    //         $this->dispatch('swal', [
    //             'title' => 'Correcto!',
    //             'text' => 'personal agregado exitosamente!',
    //             'icon' => 'success',
    //         ]);
    //     } catch (\Exception $e) {
    //         // Mostrar un mensaje de error personalizado
    //         $this->dispatch('swal', [
    //             'title' => 'Error!',
    //             'text' => $e->getMessage(),
    //             'icon' => 'warning',
    //         ]);
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         // Mostrar un mensaje de error (puedes usar SweetAlert o cualquier otro método)
    //         // Si hay otros errores de validación, mostrar el primer mensaje de error
    //         $this->dispatch('swal', [
    //             'title' => 'Error!',
    //             'text' => $e->validator->errors()->first(),
    //             'icon' => 'error',
    //         ]);

    //     }
    // }
    #[On('go-submit-Registro')]
    public function submit()
    {
        try {
            $this->validate();

            foreach ($this->workers as $worker) {
                $nuevoworker = new Personal();
                $nuevoworker->rfc = $worker['rfc'];
                $nuevoworker->nombre = $worker['nombre'];

                // Si el área es 'otro', usamos `area_especifica`
                $nuevoworker->area = $worker['area'] === 'otro' ? $worker['area_especifica'] : $worker['area'];

                $nuevoworker->fecha_ingreso = $this->fecha_ingreso;
                $nuevoworker->save();

                $this->crearMovimientoAlta($nuevoworker);
            }

            $this->workers = [];
            $this->reset();
            $this->fecha_ingreso = now()->toDateString();

            $this->dispatch('movimientoAgregado');
            $this->dispatch('personalAgregado');

            $this->dispatch('swal', [
                'title' => 'Correcto!',
                'text' => 'Personal agregado exitosamente!',
                'icon' => 'success',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal', [
                'title' => 'Error!',
                'text' => $e->getMessage(),
                'icon' => 'warning',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('swal', [
                'title' => 'Error!',
                'text' => $e->validator->errors()->first(),
                'icon' => 'error',
            ]);
        }
    }

    // Función para crear el movimiento de alta
    private function crearMovimientoAlta($nuevoworker)
    {

        // Generar un folio único
        do {
            $folio = bin2hex(random_bytes(4)); // 4 bytes producen 8 caracteres hexadecimales
        } while (Movimiento::where('folio', $folio)->exists());

        // Crear un nuevo registro en la tabla de movimientos
        $movimiento = new Movimiento();
        //$movimiento->folio = 'ALTA_' . uniqid(); // Puedes usar un folio único para el movimiento de alta
        $movimiento->folio = $folio;
        $movimiento->tipo_moviento = 'REGISTRO';
        $movimiento->fecha = now(); // O puedes usar la fecha actual
        $movimiento->estado = 'N/A';
        $movimiento->observaciones = 'Se dio de alta ' . $nuevoworker->nombre . ' en el sistema';
        $movimiento->personal_id = $nuevoworker->id; // Establece el ID del bien asociado al movimiento de alta

        $movimiento->save();
    }
}
