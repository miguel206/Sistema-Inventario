<?php

namespace App\Livewire\Movimientos\Bienes;

use App\Models\Movimiento;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TablaDevolucion extends Component
{

    use WithPagination;
    public $search = '';
    public $paginateDinamico = 5;

    // Habilitar la sincronización de 'search' con la URL
    protected $queryString = ['search' => ['except' => '']];

    #[On('DevolucionAgregado')]
    public function render()
    {
        $movimientos = Movimiento::where('tipo_moviento', 'DEVOLUCION')
            ->where(function ($query) {
                $query->where('observaciones', 'like', '%' . $this->search . '%')
                    ->orWhere('folio', 'like', '%' . $this->search . '%')
                    ->orWhere('fecha', 'like', '%' . $this->search . '%')
                    ->orWhereHas('bien', function ($bienQuery) {
                        $bienQuery->withTrashed() // Incluir bienes soft deleted
                            ->where('descripcion', 'like', '%' . $this->search . '%')
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
            ->with(['bien' => function ($query) {
                $query->withTrashed(); // Incluir bienes soft deleted en la relación
            }, 'personal']) // Cargar bienes y personal asociados
            ->orderBy('created_at', 'desc')
            ->paginate($this->paginateDinamico);

        // Agrupar movimientos por folio
        $movimientosAgrupados = $movimientos->groupBy('folio')->map(function ($group) {
            return [
                'fecha' => $group->first()->fecha,
                'biens' => $group->flatMap(function ($movimiento) {
                    return $movimiento->bien;
                })->unique(), // Asegurarse de que los bienes sean únicos
                'personal' => $group->first()->personal // Obtener el personal asociado
            ];
        });

        return view('livewire.movimientos.bienes.tabla-devolucion', [
            'movimientosAgrupados' => $movimientosAgrupados,
            'movimientosPaginados' => $movimientos // Pasar los movimientos paginados a la vista
        ]);
    }
}
