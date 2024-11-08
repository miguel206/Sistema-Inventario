<?php

namespace App\Livewire\Bienes;

use App\Models\Bien;
use App\Models\Movimiento;
use Livewire\Attributes\On;
use Livewire\Component;
use PhpParser\Node\Stmt\TryCatch;

class AltaBienes extends Component
{

    public $open = false;
    public $descripcion, $marca, $modelo, $numero_serie, $numero_inventario, $precio, $observaciones;
    public $bienes = [];
    public $fecha_ingreso;
    public $factura;

    public $formVisible = true;
    public $isClosing = false;

    public function render()
    {
        return view('livewire.bienes.alta-bienes');
    }

    #[On('openAbrirDinamico')]
    public function abrirModal()
    {
        $this->open = true; // Abre el modal
        $this->fecha_ingreso =  now()->toDateString();
    }

    public function rules()
    {
        return [
            'factura' => 'nullable|string|max:255',
            'fecha_ingreso' => 'required|date',

            'descripcion' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'numero_inventario' => 'nullable|unique:biens,numero_inventario|required_without:numero_serie',
            'numero_serie' => 'nullable|unique:biens,numero_serie|required_without:numero_inventario',
            'precio' => 'nullable|numeric',
            'observaciones' => 'nullable|string|max:1000',

        ];
    }

    public function messages()
    {
        return [
            'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria',
            'descripcion.required'   => 'La descripción es obligatoria',
            'marca.required'         => 'La marca es obligatoria',
            'modelo.required'        => 'El modelo es obligatorio',

            'fecha_ingreso.date' => 'Fecha de ingreso tiene que ser una fecha valida',

            'numero_inventario.required_without' => 'El número de inventario es obligatorio si no se ha proporcionado un número de serie.',
            'numero_serie.required_without'      => 'El número de serie es obligatorio si no se ha proporcionado un número de inventario.',

            'numero_inventario.unique' => "El número de inventario {$this->numero_inventario} ya ha sido tomado.",
            'numero_serie.unique'      => "El número de serie {$this->numero_serie} ya ha sido tomado.",

            'precio.numeric' => 'El precio solo debe de contener numeros decimales',

            'factura.string'       => 'Factura debe de ser una cadena de texto',
            'descripcion.string'   => 'Descripción debe de ser una cadena de texto',
            'marca.string'         => 'Marca debe de ser una cadena de texto',
            'modelo.string'        => 'Modelo debe de ser una cadena de texto',
            'observaciones.string' => 'Observaciones debe de ser una cadena de texto',

            'factura.max'       => 'Factura supera el limite de caracteres permitidos',
            'descripcion.max'   => 'Descripcion supera el limite de caracteres permitidos',
            'marca.max'         => 'Marca supera el limite de caracteres permitidos',
            'modelo.max'        => 'Modelo supera el limite de caracteres permitidos',
            'observaciones.max' => 'Observaciones supera el limite de caracteres permitidos',
            // Otros mensajes personalizados aquí...
        ];
    }


    public function addBien()
    {
        try {
            //code...
            // Validar los campos antes de agregar a la tabla temporal
            $this->validate();

            foreach ($this->bienes as $bien) {
                if ($bien['numero_inventario'] === $this->numero_inventario && !empty($this->numero_inventario)) {
                    throw new \Exception("Ya se introdujo ese Número de inventario: {$this->numero_inventario}");
                }
                if ($bien['numero_serie'] === $this->numero_serie && !empty($this->numero_serie)) {
                    throw new \Exception("Ya se introdujo ese Número de serie: {$this->numero_serie}");
                }
            }

            // Agregar los datos del bien al array temporal
            $nuevoBien = [
                'descripcion' => $this->descripcion,
                'marca' => $this->marca,
                'modelo' => $this->modelo,
                'numero_serie' => $this->numero_serie,
                'numero_inventario' => $this->numero_inventario,
                'precio' => $this->precio,
                'observaciones' => $this->observaciones,
            ];

            // Usar array_push o un simple array_merge para agregar el bien
            $this->bienes[] = $nuevoBien;

            // Limpiar los campos del formulario
            $this->resetForm();

            // Mostrar un mensaje de éxito
            $this->dispatch('swal', [
                'title' => 'Correcto!',
                'text' => 'Bien agregado a la tabla',
                'icon' => 'success',
            ]);

            // Ocultar el formulario después de agregar el primer bien
            if (count($this->bienes) > 0) {
                $this->formVisible = false;
            }
        } catch (\Exception $e) {
            //throw $th;
            // Mostrar un mensaje de error personalizado
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
    public function abrirFormulario()
    {
        // Mostrar el formulario
        $this->formVisible = true;
    }

    public function resetForm()
    {
        $this->descripcion = '';
        $this->marca = '';
        $this->modelo = '';
        $this->numero_serie = '';
        $this->numero_inventario = '';
        $this->precio = '';
        $this->observaciones = '';
    }

    #[On('go-submitAltas')]
    public function submitAltas()
    {
        try {
            // Validar los datos (si es necesario)
            // Puedes validar el contenido de la tabla si es necesario, pero aquí no se toman en cuenta los datos del formulario

            // Verificar que haya bienes en la tabla
            if (empty($this->bienes)) {
                throw new \Exception("No hay bienes en la tabla para agregar.");
            }

            foreach ($this->bienes as $bien) {
                // Agregar los datos del bien al array para JSON
                $bienesDatos[] = [
                    'numero_inventario' => $bien['numero_inventario'],
                    'numero_serie' => $bien['numero_serie'],
                    'descripcion' => $bien['descripcion'],
                    'modelo' => $bien['modelo'],
                    'marca' => $bien['marca'],
                    'precio' => $bien['precio'],
                    'observaciones' => $bien['observaciones'],
                ];
            }
            // Convertir los datos de los bienes a JSON
            $datosBienesJSON = json_encode($bienesDatos);

            // Crear un nuevo movimiento con el folio generado y la cantidad de bienes
            $cantidadBienes = count($this->bienes);

            // Generar un folio único
            do {
                $folio = bin2hex(random_bytes(4)); // 4 bytes producen 8 caracteres hexadecimales
            } while (Movimiento::where('folio', $folio)->exists());

            // Crear un nuevo movimiento con el folio generado
            $this->crearMovimiento($folio, $cantidadBienes, $datosBienesJSON);

            // Iterar sobre cada bien y guardarlo en la base de datos
            foreach ($this->bienes as $bien) {
                // Crear una nueva instancia del modelo Bien
                $nuevoBien = new Bien();
                $nuevoBien->numero_inventario = $bien['numero_inventario'];
                $nuevoBien->numero_serie = $bien['numero_serie'];
                $nuevoBien->descripcion = $bien['descripcion'];
                $nuevoBien->modelo = $bien['modelo'];
                $nuevoBien->marca = $bien['marca'];
                $nuevoBien->precio = isset($bien['precio']) && $bien['precio'] !== '' ? $bien['precio'] : 0;
                $nuevoBien->observaciones = $bien['observaciones'];
                $nuevoBien->factura = $this->factura; // Asignar la factura si aplica
                $nuevoBien->fecha_ingreso = $this->fecha_ingreso; // Asignar la fecha de ingreso si aplica

                // Guardar el bien en la base de datos
                $nuevoBien->save();

                // Asociamos el bien al movimiento en la tabla pivote con el mismo folio
                $this->asociarBienAMovimiento($nuevoBien, $folio);
            }

            // Limpiar la tabla de bienes
            $this->bienes = [];

            $this->open = false;

            $this->dispatch('bienAgregado');
            $this->dispatch('movimientoAgregado');


            // Mostrar un mensaje de éxito
            $this->dispatch('swal', [
                'title' => 'Correcto!',
                'text' => 'Bienes agregados exitosamente!',
                'icon' => 'success',
            ]);
        } catch (\Exception $e) {
            // Mostrar un mensaje de error personalizado
            $this->dispatch('swal', [
                'title' => 'Error!',
                'text' => $e->getMessage(),
                'icon' => 'warning',
            ]);
        }
    }

    private function crearMovimiento($folio, $cantidadBienes, $datosBienesJSON)
    {
        // Crear un nuevo registro en la tabla de movimientos
        $movimiento = new Movimiento();
        $movimiento->folio = $folio; // Asignamos el mismo folio a todos los movimientos
        $movimiento->tipo_moviento = 'ALTA';
        $movimiento->fecha = now(); // O puedes usar la fecha actual
        // Condición para ajustar el mensaje de observaciones
        if ($cantidadBienes === 1) {
            $movimiento->observaciones = 'Se dio 1 bien de alta en el inventario';
        } else {
            $movimiento->observaciones = "Se dieron {$cantidadBienes} bienes de alta en el inventario";
        }

        $movimiento->estado = 'N/A'; // Establece el estado según sea necesario
        $movimiento->cantidad = $cantidadBienes; // Establece la cantidad según sea necesario
        $movimiento->datosJSON = $datosBienesJSON; // Asigna el JSON de datos de los bienes // Establece los datos JSON según sea necesario
        $movimiento->save();
    }

    private function asociarBienAMovimiento($nuevoBien, $folio)
    {
        // Obtener el movimiento creado con el folio correspondiente
        $movimiento = Movimiento::where('folio', $folio)->first();

        // Asociar el bien al movimiento en la tabla pivote
        $movimiento->bien()->attach($nuevoBien->id); // Ajusta el personal_id según sea necesario
    }


    public function removeBien($index)
    {
        // Elimina el bien del array de bienes en la posición indicada
        unset($this->bienes[$index]);

        // Reindexa el array para evitar claves desordenadas
        $this->bienes = array_values($this->bienes);
    }

    public function closeModal() {}
}
