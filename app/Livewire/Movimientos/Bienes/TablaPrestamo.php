<?php

namespace App\Livewire\Movimientos\Bienes;

use App\Models\Movimiento;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TablaPrestamo extends Component
{
    use WithPagination;
    public $search = '';
    public $paginateDinamico = 5;

    // Habilitar la sincronización de 'search' con la URL
    protected $queryString = ['search' => ['except' => '']];



    #[On('prestamoAgregado')]
    public function render()
    {
        $movimientos = Movimiento::where('tipo_moviento', 'RESGUARDO')
            ->where(function ($query) {
                $query->where('observaciones', 'like', '%' . $this->search . '%')
                    ->orWhere('folio', 'like', '%' . $this->search . '%')
                    ->orWhere('fecha', 'like', '%' . $this->search . '%')
                    ->orWhere('estado', 'like', '%' . $this->search . '%')
                    ->orWhereHas('PrestamoTable', function ($bienQuery) {
                        $bienQuery->where('descripcion', 'like', '%' . $this->search . '%')
                            ->orWhere('modelo', 'like', '%' . $this->search . '%')
                            ->orWhere('marca', 'like', '%' . $this->search . '%')
                            ->orWhere('numero_inventario', 'like', '%' . $this->search . '%')
                            ->orWhere('numero_serie', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('personal', function ($query) {
                        $query->where('nombre', 'like', '%' . $this->search . '%')
                            ->orWhere('area', 'like', '%' . $this->search . '%');
                    });
            })
            ->with([
                'PrestamoTable'=> function ($query) {
                    $query->withPivot('devuelto'); // Asegúrate de incluir 'devuelto'
                }, // Usar la nueva relación PrestamoTable
                'personal'
            ])
            ->orderBy('created_at', 'desc')
            ->withTrashed() // Incluir también movimientos soft deleted
            ->paginate($this->paginateDinamico);

        // Agrupar movimientos por folio
        $movimientosAgrupados = $movimientos->groupBy('folio')->map(function ($group) {
            return [
                'fecha' => $group->first()->fecha,
                'estado' => $group->first()->estado,
                'biens' => $group->flatMap(function ($movimiento) {
                    return $movimiento->PrestamoTable; // Usar PrestamoTable aquí
                })->unique(), // Asegurarse de que los bienes sean únicos
                'personal' => $group->first()->personal // Obtener el personal asociado
            ];
        });

        return view('livewire.movimientos.bienes.tabla-prestamo', [
            'movimientosAgrupados' => $movimientosAgrupados,
            'movimientosPaginados' => $movimientos // Pasar los movimientos paginados a la vista
        ]);
    }
}
