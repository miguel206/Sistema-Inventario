<?php

namespace App\Livewire\Movimientos\Resguardo;

use App\Livewire\Movimientos\Resguardo as MovimientosResguardo;
use App\Models\Bien;
use App\Models\Movimiento;
use App\Models\Personal;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Resguardo extends Component
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
    public $perBien = 3;


    public function mount()
    {
        $this->fecha = now()->toDateString();
    }

    public function render()
    {
        $personal = Personal::where('nombre', 'like', '%' . $this->terminoBusquedaPersonals . '%')->paginate($this->perPage);

        // Filtrar los bienes disponibles que no están en selected_bienes
        $bienes = Bien::whereNotIn('id', $this->selected_bienes)
            ->where(function ($query) {
                $query->where('descripcion', 'like', '%' . $this->terminoBusquedaBienes . '%')
                    ->orWhere('numero_inventario', 'like', '%' . $this->terminoBusquedaBienes . '%')
                    ->orWhere('numero_serie', 'like', '%' . $this->terminoBusquedaBienes . '%')
                    ->orWhere('modelo', 'like', '%' . $this->terminoBusquedaBienes . '%')
                    ->orWhere('marca', 'like', '%' . $this->terminoBusquedaBienes . '%');
            })
            ->where('estado', 'DISPONIBLE')
            ->paginate($this->perBien);

        $fecha_minima_ingreso = $bienes->min('fecha_ingreso');
        $fecha_minima_ingreso = date('Y-m-d', strtotime($fecha_minima_ingreso));
        // Calcular la fecha mínima entre $fecha_minima_bienes y $fecha_minima_ingreso
        $fecha_minima = $fecha_minima_ingreso;

        return view('livewire.movimientos.resguardo.resguardo', [
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

    protected $rules = [
        'fecha' => 'required|date',
        'observacion' => 'nullable|string|max:1000',
    ];

    public function messages()
    {
        // Agregamos otros mensajes de validación personalizados si es necesario
        //$messages['factura.required'] = 'El campo factura es obligatorio.';
        $messages['fecha.required'] = 'El campo fecha de ingreso es obligatorio.';
        $messages['fecha.date'] = 'El campo fecha de ingreso debe de ser una fecha.';

        $messages['observacion.string'] = 'El campo observaciones debe ser una cadena de texto.';
        $messages['observacion.max'] = 'El campo observaciones no debe superar los 255 caracteres.';

        return $messages;
    }

    #[On('go-submit-prestamo')]
    public function submit()
    {
        try {
            // Validar si se ha seleccionado un empleado y al menos un bien
            if (!$this->selected_personal) {
                // Mostrar advertencia con Swal
                $this->dispatch('swal', [
                    'title' => 'Advertencia',
                    'text' => 'Debe seleccionar un empleado.',
                    'icon' => 'warning',
                ]);
                return; // Detener la ejecución si no se cumplen las condiciones
            }

            if (empty($this->selected_bienes)) {
                // Mostrar advertencia con Swal
                $this->dispatch('swal', [
                    'title' => 'Advertencia',
                    'text' => 'Debe seleccionar al menos un bien antes de continuar.',
                    'icon' => 'warning',
                ]);
                return; // Detener la ejecución si no se cumplen las condiciones
            }

            $this->validate();

            // Generar un número de folio único para el conjunto de movimientos
            //$folio = 'RESG_' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

            // Generar un folio único
            do {
                $folio = bin2hex(random_bytes(4)); // 4 bytes producen 8 caracteres hexadecimales
            } while (Movimiento::where('folio', $folio)->exists());

            // Crear una nueva instancia del modelo de Movimiento
            $movimiento = new Movimiento();

            // Asignar los valores de los campos correspondientes
            $movimiento->folio = $folio;
            $movimiento->tipo_moviento = 'RESGUARDO';
            $movimiento->fecha = $this->fecha;
            $movimiento->observaciones = $this->observacion;
            $movimiento->personal_id = $this->selected_personal->id;
            $movimiento->estado = 'COMPLETO'; // Por defecto, el estado es "COMPLETO"
            $movimiento->cantidad = count($this->selected_bienes); // Cantidad de bienes asociados al movimiento

            // Guardar el movimiento en la base de datos
            $movimiento->save();

            // Asociar los bienes al movimiento en la tabla pivote y actualizar su estado
            $this->asociarBienAMovimiento($movimiento);

            // Disparar eventos o mostrar mensajes de éxito
            $this->dispatch('movimientoAgregado');
            $this->dispatch('prestamoAgregado');
            
            // $this->dispatch('movimientoAgregado')->to(MovimientosResguardo::class);
            $this->dispatch('swal', [
                'title' => 'Correcto!',
                'text' => 'Resguardo agregado exitosamente!',
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
        } catch (\Exception $e) {
            // Mostrar un mensaje de error personalizado
            $this->dispatch('swal', [
                'title' => 'Error!',
                'text' => $e->getMessage(),
                'icon' => 'warning',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Mostrar un mensaje de error (puedes usar SweetAlert o cualquier otro método)
            // Si hay otros errores de validación, mostrar el primer mensaje de error
            $this->dispatch('swal', [
                'title' => 'Error!',
                'text' => $e->validator->errors()->first(),
                'icon' => 'error',
            ]);
        }
    }

    private function asociarBienAMovimiento($movimiento)
    {
        // Obtener los IDs de los bienes seleccionados
        $bienesIds = $this->selected_bienes;

        // Asociar cada bien al movimiento en la tabla pivote
        foreach ($bienesIds as $bienId) {
            $movimiento->bien()->attach($bienId);
            $bien = Bien::findOrFail($bienId);
            // Cambiar el estado del bien a "RESGUARDADO" y asociarlo con el personal seleccionado
            $bien->estado = 'RESGUARDO';
            $bien->personal_id = $this->selected_personal->id;
            $bien->save();
        }
    }
}
