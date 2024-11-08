<?php

namespace App\Livewire\Movimientos\Resguardo;

use App\Models\Bien;
use App\Models\Movimiento;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Cancelar extends Component
{
    public $open = false;
    public $searchFolio = '';
    public $selectedFolio;

    public $observacion;
    public $fecha;

    public $perPage = 1;

    public function mount()
    {
        $this->fecha = now()->toDateString();
    }

    public function selectFolio($folioId)
    {
        $this->selectedFolio = Movimiento::findOrFail($folioId);
        $this->searchFolio = '';
    }

    public function render()
    {
        $searchResults = Movimiento::where('tipo_moviento', 'RESGUARDO')
            ->where('estado', '<>', 'TERMINADO')
            ->where('estado', '<>', 'CANCELADO')
            ->where('estado', '<>', 'N/A')
            ->where('folio', 'like', '%' . $this->searchFolio . '%')
            ->paginate($this->perPage);

        return view('livewire.movimientos.resguardo.cancelar', [
            'searchResults' => $searchResults,
        ]);
    }

    public function clearSelection()
    {
        $this->selectedFolio = null;
    }

    public function cancelResguardo()
    {
        // Validar los campos
        $this->validate([
            'observacion' => 'nullable|string|max:255',
            'fecha' => 'required|date',
        ]);

        if ($this->selectedFolio) {
            // Obtener los bienes asociados al movimiento
            $bienes = $this->selectedFolio->bien()->pluck('bien_id')->toArray();

            // Realizar soft delete en la tabla pivote para todos los bienes asociados
            DB::table('movimiento_bien')
                ->whereIn('bien_id', $bienes)
                ->where('movimiento_id', $this->selectedFolio->id)
                ->update(['deleted_at' => now()]);

            // Desvincular los bienes del personal y actualizar su estado
            Bien::whereIn('id', $bienes)->update(['personal_id' => null, 'estado' => 'DISPONIBLE']);

            // Actualizar el estado del movimiento a "CANCELADO"
            $this->selectedFolio->update([
                'estado' => 'CANCELADO',
                'observacion' => $this->observacion,
                'fecha_termino' => $this->fecha,
            ]);

            // Crear un nuevo movimiento de tipo "DEVOLUCION" para registrar la devolución de bienes
            $folio = 'CANCEL_' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

            $movimiento = new Movimiento();
            $movimiento->folio = $folio;
            $movimiento->tipo_moviento = 'CANCELACION';
            $movimiento->fecha = $this->fecha;
            $movimiento->observaciones = $this->observacion;
            $movimiento->personal_id = $this->selectedFolio->personal_id;
            $movimiento->estado = 'N/A';
            $movimiento->save();

            // Asociar los bienes al movimiento de devolución
            $this->asociarBienAMovimiento($movimiento, $bienes);
            
            // Disparar eventos o mostrar mensajes de éxito
            $this->dispatch('movimientoAgregado');
            
            // Mostrar un mensaje de éxito
            session()->flash('success', 'Resguardo cancelado exitosamente');
            $this->dispatch('swal', [
                'title' => '¡Éxito!',
                'text' => 'Resguardo cancelado exitosamente!',
                'icon' => 'success',
            ]);

            // Reiniciar variables
            $this->reset(['observacion', 'fecha', 'selectedFolio', 'searchFolio']);
            $this->open = false;
        }
    }

    private function asociarBienAMovimiento($movimiento, $bienesIds)
    {
        // Asociar cada bien al movimiento en la tabla pivote
        foreach ($bienesIds as $bienId) {
            $movimiento->bien()->attach($bienId);
        }
    }
}
