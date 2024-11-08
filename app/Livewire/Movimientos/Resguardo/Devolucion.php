<?php

namespace App\Livewire\Movimientos\Resguardo;

use App\Models\Bien;
use App\Models\Movimiento;
use App\Models\Personal;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Devolucion extends Component
{
    use WithPagination;
    public $open = false;

    public $searchPersonal = '';

    public $selectedPersonal;
    public $selectedBienes = [];
    public $observacion;
    public $fecha;
    public $bienesResguardo;
    public $fecha_minima;
    //public $fecha_termino;

    public $perPage = 1;

    public function mount()
    {
        $this->fecha = now()->toDateString();
        $this->bienesResguardo = collect();
    }

    public function render()
    {
        $personal = [];

        if ($this->searchPersonal) {
            $personal = Personal::where('nombre', 'like', '%' . $this->searchPersonal . '%')
                ->orWhere('area', 'like', '%' . $this->searchPersonal . '%')
                ->paginate($this->perPage);
        }

        return view('livewire.movimientos.resguardo.devolucion', [
            'personal' => $personal,
        ]);
    }

    public function selectPersonal($id)
    {
        $this->selectedPersonal = Personal::findOrFail($id);
        $this->searchPersonal = ''; // Limpiar la búsqueda después de seleccionar un personal

        // Buscar los movimientos de tipo "RESGUARDO" y estado "COMPLETO" o "PARCIAL" asociados al personal seleccionado
        $movimientos = Movimiento::where('personal_id', $this->selectedPersonal->id)
            ->where('tipo_moviento', 'RESGUARDO')
            ->whereIn('estado', ['COMPLETO', 'PARCIAL'])
            ->get();

        // Obtener los bienes asociados a los movimientos encontrados, excluyendo los que tienen 'deleted_at' en la tabla pivote
        $this->bienesResguardo = Bien::whereHas('movimientos', function ($query) use ($movimientos) {
            $query->whereIn('movimiento_id', $movimientos->pluck('id'))
                ->whereNull('movimiento_bien.deleted_at');
        })->get();
    }

    public function clearSelection()
    {
        $this->selectedPersonal = null;
        $this->bienesResguardo = collect();
    }

    public function selectAll()
    {
        // $this->selectedBienes = $this->bienesResguardo->pluck('id')->toArray();
        if (count($this->selectedBienes) === $this->bienesResguardo->count()) {
            $this->selectedBienes = [];
        } else {
            $this->selectedBienes = $this->bienesResguardo->pluck('id')->toArray();
        }
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




    #[On('go-submit-devolucion')]
    public function submit2()
    {

        // Validar si se ha seleccionado un empleado y al menos un bien
        if (!$this->selectedPersonal) {
            // Mostrar advertencia con Swal
            $this->dispatch('swal', [
                'title' => 'Advertencia',
                'text' => 'Debe seleccionar un empleado.',
                'icon' => 'warning',
            ]);
            return; // Detener la ejecución si no se cumplen las condiciones
        }

        if (empty($this->selectedBienes)) {
            // Mostrar advertencia con Swal
            $this->dispatch('swal', [
                'title' => 'Advertencia',
                'text' => 'Debe seleccionar al menos un bien antes de continuar.',
                'icon' => 'warning',
            ]);
            return; // Detener la ejecución si no se cumplen las condiciones
        }

        $this->validate();


        // Obtener los movimientos de tipo "RESGUARDO" asociados al personal seleccionado
        $movimientos = Movimiento::where('personal_id', $this->selectedPersonal->id)
            ->where('tipo_moviento', 'RESGUARDO')
            ->whereIn('estado', ['COMPLETO', 'PARCIAL'])
            ->get();

        foreach ($movimientos as $movimiento) {
            $bienesMovimiento = $movimiento->bien()->pluck('bien_id')->toArray();
            $bienesDevolver = array_intersect($bienesMovimiento, $this->selectedBienes);

            // Realizar soft delete en la tabla pivote para los bienes seleccionados
            DB::table('movimiento_bien')
                ->whereIn('bien_id', $bienesDevolver)
                ->where('movimiento_id', $movimiento->id)
                ->update([
                    'deleted_at' => now(),
                    'devuelto' => true
                ]);

            // Desvincular los bienes seleccionados del personal
            Bien::whereIn('id', $bienesDevolver)->update(['personal_id' => null, 'estado' => 'DISPONIBLE']);

            // Verificar si todos los bienes del movimiento han sido devueltos
            $bienesRestantes = DB::table('movimiento_bien')
                ->where('movimiento_id', $movimiento->id)
                ->whereNull('deleted_at')
                ->count();

            if ($bienesRestantes === 0) {
                $movimiento->update([
                    'estado' => 'TERMINADO',
                    'fecha_termino' => $this->fecha,
                ]);
            } elseif (count($bienesDevolver) > 0) {
                // Si se devolvieron algunos pero no todos los bienes del movimiento
                $movimiento->update(['estado' => 'PARCIAL']);
            }
        }

        // Generar un número de folio único para el conjunto de movimientos
        // $folio = 'DEVO_' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Generar un folio único
        do {
            $folio = bin2hex(random_bytes(4)); // 4 bytes producen 8 caracteres hexadecimales
        } while (Movimiento::where('folio', $folio)->exists());

        // Crear una nueva instancia del modelo de Movimiento
        $movimiento = new Movimiento();

        // Asignar los valores de los campos correspondientes
        $movimiento->folio = $folio;
        $movimiento->tipo_moviento = 'DEVOLUCION';
        $movimiento->fecha = $this->fecha;
        $movimiento->personal_id = $this->selectedPersonal->id;
        $movimiento->estado = 'N/A';

        // Generar observación por defecto si está vacío o es nulo
        if (empty($this->observacion)) {
            $observacion = 'Se hizo la devolución de ';
            $detalles = [];

            foreach ($this->selectedBienes as $bienId) {
                $bien = Bien::find($bienId);
                $descripcion = $bien->descripcion;
                $marca = $bien->marca;
                $identificador = $bien->numero_inventario ? $bien->numero_inventario : ($bien->numero_serie ? $bien->numero_serie : '');
                $detalles[] = "{$descripcion}, {$marca}, {$identificador}";
            }

            $movimiento->observaciones = $observacion . implode('; ', $detalles);
        } else {
            $movimiento->observaciones = $this->observacion;
        }

        $movimiento->save();

        // Asociar los bienes al movimiento en la tabla pivote y actualizar su estado
        $this->asociarBienAMovimiento($movimiento);

        // Disparar eventos o mostrar mensajes de éxito
        $this->dispatch('movimientoAgregado');
        $this->dispatch('DevolucionAgregado');
        $this->dispatch('swal', [
            'title' => 'Correcto!',
            'text' => 'Devolución exitosa!',
            'icon' => 'success',
        ]);

        // Limpiar selección
        $this->selectedBienes = [];
        $this->selectedPersonal = null;
        $this->bienesResguardo = collect();
        $this->open = false;
    }

    private function asociarBienAMovimiento($movimiento)
    {
        // Obtener los IDs de los bienes seleccionados
        $bienesIds = $this->selectedBienes;

        // Asociar cada bien al movimiento en la tabla pivote
        foreach ($bienesIds as $bienId) {
            $movimiento->bien()->attach($bienId);
            $bien = Bien::findOrFail($bienId);
            // // Cambiar el estado del bien a "RESGUARDADO" y asociarlo con el personal seleccionado
            // $bien->estado = 'RESGUARDO';
            // $bien->personal_id = $this->selected_personal->id;
            // $bien->save();
        }
    }
}
