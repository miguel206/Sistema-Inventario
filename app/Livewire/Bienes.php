<?php

namespace App\Livewire;

use App\Models\Bien;
use App\Models\Movimiento;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use phpDocumentor\Reflection\Types\This;
use Illuminate\Support\Facades\Log;


class Bienes extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $paginateDinamico = 10;

    // Habilitar la sincronización de 'search' con la URL
    protected $queryString = ['search' => ['except' => '']];

    #[On('bienAgregado')]
    public function render()
    {
        //$bienes = Bien::orderBy('created_at', 'desc')->paginate(10);
        $bienes = Bien::query()
            ->where('numero_inventario', 'LIKE', '%' . $this->search . '%')
            ->orWhere('numero_serie', 'LIKE', '%' . $this->search . '%')
            ->orWhere('descripcion', 'LIKE', '%' . $this->search . '%')
            ->orWhere('modelo', 'LIKE', '%' . $this->search . '%')
            ->orWhere('marca', 'LIKE', '%' . $this->search . '%')
            ->orWhere('fecha_ingreso', 'LIKE', '%' . $this->search . '%')
            ->orWhere('estado', 'LIKE', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->paginateDinamico);

        // return view('livewire.bienes', [
        //     'bienes' => $bienes
        // ]);
        return view('livewire.bienes', compact('bienes'));
    }

    //---------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------
    public $bienesEdit = [];
    public $showModal = false;
    public $bien;

    public $showModalview = false;
    public $bienInfo;


    public $edit_id;
    public $edit_numero_inventario;
    public $edit_numero_serie;
    public $edit_descripcion;
    public $edit_modelo;
    public $edit_marca;
    public $edit_precio;
    public $edit_factura;
    public $edit_observaciones;
    public $edit_estado;

    //========================================================================================
    // Método UPTATE
    //========================================================================================
    public function openModal($id)
    {
        // Establece el ID del bien que se está editando
        $this->edit_id = $id;
        // Buscar el bien en la base de datos por su ID
        $bien = Bien::findOrFail($id);

        // Asignar los valores del bien a las propiedades correspondientes
        $this->edit_numero_inventario = $bien->numero_inventario;
        $this->edit_numero_serie = $bien->numero_serie;
        $this->edit_descripcion = $bien->descripcion;
        $this->edit_modelo = $bien->modelo;
        $this->edit_marca = $bien->marca;
        $this->edit_precio = $bien->precio;
        $this->edit_factura = $bien->factura;
        $this->edit_observaciones = $bien->observaciones;
        $this->edit_estado = $bien->estado;

        // Mostrar el modal
        $this->showModal = true;
    }

    public function rules()
    {
        return [
            'edit_numero_inventario' => 'nullable|unique:biens,numero_inventario,' . $this->edit_id . '|required_without:edit_numero_serie',
            'edit_numero_serie'      => 'nullable|unique:biens,numero_serie,' . $this->edit_id . '|required_without:edit_numero_inventario',
            'edit_descripcion'       => 'required|string|max:255',
            'edit_modelo'            => 'required|string|max:255',
            'edit_marca'             => 'required|string|max:255',
            'edit_precio'            => 'nullable|numeric',
            'edit_factura'           => 'nullable|string|max:255',
            'edit_observaciones'     => 'nullable|string|max:1000',
            'edit_estado'            => 'required|in:DISPONIBLE,MANTENIMIENTO',
        ];
    }

    public function messages()
    {
        return [
            'edit_numero_inventario.unique'           => "El número de inventario ya ha sido tomado.",
            'edit_numero_serie.unique'                => "El número de serie ya ha sido tomado.",
            'edit_numero_inventario.required_without' => "Ingrese número de inventario o número de serie.",
            'edit_numero_serie.required_without'      => "Ingrese número de serie o número de inventario.",
            'edit_descripcion.required'               => "La descripción es obligatoria.",
            'edit_modelo.required'                    => "El modelo es obligatorio.",
            'edit_marca.required'                     => "La marca es obligatoria.",
            'edit_precio.numeric'                     => "El precio debe ser numérico.",
            //'edit_factura.required' => "La factura es obligatoria.",
            'edit_factura.max'                        => "La factura no deben exceder los 255 caracteres.",
            'edit_observaciones.max'                  => "Las observaciones no deben exceder los 1000 caracteres.",
            'edit_estado.required'                    => "El estado es obligatorio.",
            'edit_estado.in'                          => "El estado debe ser 'DISPONIBLE' o 'MANTENIMIENTO'.",
        ];
    }


    #[On('go-updateBien')]
    public function updateBien()
    {
        try {
            // Validar los campos antes de actualizar
            $this->validate($this->rules(), $this->messages());

            // Encuentra el bien a actualizar por su ID
            $bien = Bien::findOrFail($this->edit_id);

            // Capturar el estado anterior del bien
            $bienAntes = $bien->toArray();

            // Actualiza los datos del bien
            $bien->update([
                'numero_inventario' => $this->edit_numero_inventario,
                'numero_serie' => $this->edit_numero_serie,
                'descripcion' => $this->edit_descripcion,
                'modelo' => $this->edit_modelo,
                'marca' => $this->edit_marca,
                'precio' => $this->edit_precio,
                'factura' => $this->edit_factura,
                'observaciones' => $this->edit_observaciones,
                'estado' => $this->edit_estado,
            ]);

            // Capturar el estado posterior del bien
            $bienDespues = $bien->toArray();

            // Crear un registro de movimiento con el estado anterior y posterior
            $this->crearMovimientoACTUALIZACION($bien, $bienAntes, $bienDespues);

            // Cierra el modal después de la actualización
            $this->showModal = false;

            // Mostrar un mensaje de éxito
            session()->flash('success', 'Bien actualizado exitosamente');
            $this->dispatch('swal', [
                'title' => 'Éxito!',
                'text' => 'Bien actualizado exitosamente!',
                'icon' => 'success',
            ]);
        } catch (\Exception $e) {
            // Mostrar un mensaje de error personalizado
            $this->dispatch('swal', [
                'title' => 'Error!',
                'text' => $e->getMessage(),
                'icon' => 'warning',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Mostrar un mensaje de error de validación
            $this->dispatch('swal', [
                'title' => 'Error!',
                'text' => $e->validator->errors()->first(),
                'icon' => 'error',
            ]);
        }
    }



    private function crearMovimientoACTUALIZACION($bien, $bienAntes, $bienDespues)
    {
        // Generar un folio único
        do {
            $folio = bin2hex(random_bytes(4)); // 4 bytes producen 8 caracteres hexadecimales
        } while (Movimiento::where('folio', $folio)->exists());

        // Crear un nuevo registro en la tabla de movimientos
        $movimiento = new Movimiento();
        $movimiento->folio = $folio;
        $movimiento->tipo_moviento = 'ACTUALIZACION';
        $movimiento->fecha = now();
        $movimiento->observaciones = 'Se editó la información de un bien del inventario';
        $movimiento->estado = 'N/A';

        // Guardar el estado anterior y posterior en el atributo datosJSON
        $cambios = [
            'antes' => $bienAntes,
            'despues' => $bienDespues,
        ];

        // Guardar el JSON en el atributo datosJSON
        $movimiento->datosJSON = json_encode($cambios);

        $movimiento->save();

        // Obtener el ID del movimiento creado
        $movimientoId = $movimiento->id;

        // Asociar el bien al movimiento en la tabla pivote
        $bien->movimientos()->attach($movimientoId);
    }


    // Método para cerrar el modal
    public function closeModal()
    {
        $this->showModal = false;
    }

    public function toggleEstado()
    {
        $this->edit_estado = $this->edit_estado === 'DISPONIBLE' ? 'MANTENIMIENTO' : 'DISPONIBLE';
    }

    public function setEstado($estado)
    {
        $this->edit_estado = $estado;
    }
    //================================================================================

    function save()
    {
        $this->dispatch('swal', [
            'title' => 'Success!',
            'text' => 'Data guardados succesfully!',
            'icon' => 'success',
        ]);
    }

    #[On('goOn-Delete')]
    function delete()
    {
        // $this->dispatch('swal',[
        //     'title' => 'Success!',
        //     'text' => 'Data guardados succesfully!',
        //     'icon' => 'success',
        // ]);
        dd('evento recibido');
    }
    //---------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------
    public function openModalView($id)
    {
        // Establece el ID del bien que se está editando
        $this->edit_id = $id;
        // Buscar el bien en la base de datos por su ID
        $this->bienInfo = Bien::findOrFail($id);

        // Abrir el modal
        $this->showModalview = true;
        //dd($this->bien);

    }

    public function closeModalView()
    {
        $this->showModalview = false;
    }

    //---------------------------------------------------------------------------------------
    // dar de baja el bien
    //---------------------------------------------------------------------------------------
    public $showModalEstado = false;
    public $bienEstado;
    public $edit_id_estado;
    public $nuevo_estado;
    public $observacion;
    public $fecha_baja;
    public $observaciones;
    public $documento;
    public $clave;

    public function openModalEstado($id)
    {
        // Establece el ID del bien que se está editando
        $this->edit_id_estado = $id;

        // Buscar el bien en la base de datos por su ID
        $bienEstado = Bien::findOrFail($id);

        $this->nuevo_estado = $bienEstado->estado;
        // Abrir el modal
        $this->showModalEstado = true;

        //dd($id);
    }

    public function mount()
    {
        $this->fecha_baja = now()->toDateString();
    }

    // Función que contiene las reglas de validación
    protected function rules2()
    {
    return [
        'observaciones' => 'required|string|max:255',
        'fecha_baja' => 'required|date',
        'documento' => 'nullable|file|mimes:pdf|max:5048', // Ahora el documento es opcional
        'clave' => 'required|string',
    ];
    }

    // Función que contiene los mensajes de validación personalizados
    protected function messages2()
    {
        return [
            'observaciones.required' => 'Las observaciones son obligatorias.',
            'observaciones.string' => 'Las observaciones deben ser una cadena de texto.',
            'observaciones.max' => 'Las observaciones no deben exceder los 255 caracteres.',
            'fecha_baja.required' => 'La fecha de baja es obligatoria.',
            'fecha_baja.date' => 'La fecha de baja debe ser una fecha válida.',
            //'documento.required' => 'El documento es obligatorio.',
            'documento.file' => 'El documento debe ser un archivo.',
            'documento.mimes' => 'El documento debe ser un archivo PDF.',
            'documento.max' => 'El documento no debe exceder los 5MB.',
            'clave.required' => 'La clave es obligatoria.',
            'clave.string' => 'La clave debe ser una cadena de texto.',
        ];
    }

    #[On('go-updateEstado')]
    public function updateEstado()
    {
        try {
            // Validar los campos
            $validatedData = $this->validate($this->rules2(), $this->messages2());

            // Validar la clave
            if ($this->clave !== 'adminUTSI') {
                throw new \Exception('Clave incorrecta.');
            }

            // Buscar el bien en la base de datos por su ID
            $bien = Bien::withTrashed()->findOrFail($this->edit_id_estado);

            // Verificar si la fecha de baja es anterior o igual a la fecha de ingreso
            if (strtotime($this->fecha_baja) <= strtotime($bien->fecha_ingreso)) {
                throw new \Exception('La fecha de baja no puede ser anterior o igual a la fecha de ingreso.');
            }

            // Guardar el documento
            $path = null;

            if ($this->documento) {
                $path = $this->documento->store('documentos', 'public');
                if (!$path) {
                    throw new \Exception('Error al guardar el documento.');
                }
            }

            // Actualizar el bien
            $bien->update([
                'estado' => 'BAJA',
                'observaciones' => $this->observaciones,
                'fecha_baja' => $this->fecha_baja,
                'documento' => $path, // Guardar la ruta del documento
            ]);

            // Realizar el soft delete
            $bien->delete();

            // Cerrar el modal
            $this->showModalEstado = false;

            // Llamar a la función para crear el movimiento de alta
            $this->crearMovimientoEstado($bien);

            // Mostrar un mensaje de éxito
            $this->dispatch('swal', [
                'title' => '¡Éxito!',
                'text' => '¡Bien(es) dado de baja exitosamente!',
                'icon' => 'success',
            ]);
            
            $this->reset();
            $this->fecha_baja = now()->toDateString();

        } catch (\Exception $e) {
            // Mostrar el mensaje de error usando SweetAlert (Swal.fire)
            $this->dispatch('swal', [
                'title' => 'Error!',
                'text' => $e->getMessage(),
                'icon' => 'error',
            ]);
        }
    }



    // Función para crear el movimiento de baja
    private function crearMovimientoEstado($bien)
    {
        // Generar un folio único para el movimiento de actualización
        $folio = 'BAJA_' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Crear un nuevo registro en la tabla de movimientos
        $movimiento = new Movimiento();
        $movimiento->folio = $folio;
        $movimiento->tipo_moviento = 'BAJA';
        $movimiento->fecha = now();
        $movimiento->observaciones = $bien->descripcion . ' SE DIO DE BAJA';
        $movimiento->estado = 'N/A';
        $movimiento->save();

        // Obtener el ID del movimiento creado
        $movimientoId = $movimiento->id;

        // Asociar el bien al movimiento en la tabla pivote
        $bien->movimientos()->attach($movimientoId);
    }

    public function closeModalEstado()
    {
        $this->showModalEstado = false;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////// 
    /////////////////////////////////////////////////////////////////////////////////////////////////////

    public $showModalhistorial = false;
    public $bienId;
    public $movimientos = [];

    public $bienDescripcion;
    public $bienSerie;
    public $bienInventario;

    public function openModalhistorial($bienId)
    {
        $this->bienId = $bienId;
        $bien = Bien::findOrFail($bienId);

        $this->bienDescripcion = $bien->descripcion;
        $this->bienInventario  = $bien->numero_inventario;
        $this->bienSerie       = $bien->numero_serie;


        $this->movimientos = $bien->todosLosMovimientos()
            ->orderBy('created_at', 'desc')
            ->get(); // Obtener los movimientos asociados, incluyendo los soft deleted
        // Obtener los movimientos asociados, incluyendo los soft deleted y convertir en array


        // Convertir la colección en array solo para verificar si está vacía
        if (count($this->movimientos) === 0) {
            $this->showModalhistorial = false; // No mostrar el modal si no hay movimientos
            $this->dispatch('swal', [
                'title' => 'Sin Movimientos',
                'text' => 'Este bien no tiene movimientos asociados.',
                'icon' => 'info',
            ]);
        } else {
            $this->showModalhistorial = true; // Mostrar el modal si hay movimientos
        }
    }

    // Método para cerrar el modal
    public function closeModalhistorial()
    {
        $this->showModalhistorial = false;
    }
}
