<?php

namespace App\Livewire\Movimientos\Bienes;

use App\Models\Movimiento;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TablaAltas extends Component
{
    use WithPagination;
    public $search = '';
    public $paginateDinamico = 5;

    // Habilitar la sincronización de 'search' con la URL
    protected $queryString = ['search' => ['except' => '']];

    #[On('bienAgregado')]
    public function render()
    {
        // Obtener movimientos de tipo 'ALTA' que coincidan con la búsqueda
        // $movimientos = Movimiento::where('tipo_moviento', 'ALTA')
        //     ->where('observaciones', 'like', '%' . $this->search . '%')
        //     ->with('bien') // Cargar bienes asociados
        //     ->orderBy('created_at', 'desc')
        //     ->paginate($this->paginateDinamico);

        // Obtener movimientos de tipo 'ALTA' que coincidan con la búsqueda
        $movimientos = Movimiento::where('tipo_moviento', 'ALTA')
            ->where(function ($query) {
                $query->where('observaciones', 'like', '%' . $this->search . '%')
                    ->orWhere('folio', 'like', '%' . $this->search . '%')
                    ->orWhere('fecha', 'like', '%' . $this->search . '%')
                    ->orWhereHas('bien', function ($bienQuery) {
                        $bienQuery->withTrashed()
                        ->where('descripcion', 'like', '%' . $this->search . '%')
                            ->orWhere('modelo', 'like', '%' . $this->search . '%')
                            ->orWhere('marca', 'like', '%' . $this->search . '%')
                            ->orWhere('numero_inventario', 'like', '%' . $this->search . '%')
                            ->orWhere('numero_serie', 'like', '%' . $this->search . '%');
                    });
            })
            ->with(['bien' => function ($query) {
                $query->withTrashed(); // Incluir bienes soft deleted en la relación
            }]) // Cargar bienes asociados
            ->orderBy('created_at', 'desc')
            ->paginate($this->paginateDinamico);

        // Agrupar movimientos por folio
        $movimientosAgrupados = $movimientos->groupBy('folio')->map(function ($group) {
            return [
                'fecha' => $group->first()->fecha,
                'biens' => $group->flatMap(function ($movimiento) {
                    return $movimiento->bien;
                })->unique() // Asegurarse de que los bienes sean únicos
            ];
        });

        return view('livewire.movimientos.bienes.tabla-altas', [
            'movimientosAgrupados' => $movimientosAgrupados,
            'movimientosPaginados' => $movimientos // Pasar los movimientos paginados a la vista
        ]);
    }

    // public function render()
    // {
    //     $movimientos = Movimiento::where('tipo_moviento', 'ALTA')
    //         ->where('observaciones', 'like', '%' . $this->search . '%')
    //         ->with('bien') // Cargar bienes asociados
    //         ->orderBy('created_at', 'desc')
    //         ->paginate($this->paginateDinamico);

    //     // Obtener bienes asociados a los movimientos
    //     $bienes = collect();
    //     foreach ($movimientos as $movimiento) {
    //         $bienes = $bienes->merge($movimiento->bien);
    //     }


    //     return view('livewire.movimientos.bienes.tabla-altas', [
    //         'bienes' => $bienes->unique() // Asegurarse de que los bienes sean únicos
    //     ]);
    // }
}
