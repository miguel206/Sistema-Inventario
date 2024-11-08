<?php

namespace App\Livewire\Bienes;

use App\Models\Bien;
use App\Models\Movimiento;
use Livewire\Attributes\On;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;

class CrearDinamico extends Component
{
    public $open = false;
    public $bienes = [];
    public $fecha_ingreso;
    public $factura;

    public $isClosing = false;


    // public $descripcion;
    // public $modelo;
    // public $marca;
    // public $numero_serie;
    // public $numero_inventario;

    // public function mount()
    // {
    //     $this->fecha_ingreso = now()->toDateString();
    // }

    #[On('openAbrirDinamico')]
    public function abrirModal()
    {

        // $this->open = true;
        // $this->addBien();
        $this->reset(['bienes']); // Restablece la lista de bienes
        //$this->addBien(); // Agrega una sola iteración de bienes

        $this->bienes[] = [
            'numero_inventario' => '',
            'numero_serie' => '',
            'descripcion' => '',
            'modelo' => '',
            'marca' => '',
            'precio' => 0, // Inicializar como null
            'observaciones' => '',
        ];
        $this->open = true; // Abre el modal
        $this->fecha_ingreso =  now()->toDateString();
    }

    public function rules()
    {
        $rules = [
            'factura' => 'nullable|string|max:255',
            'fecha_ingreso' => 'required|date',
        ];

        foreach ($this->bienes as $index => $bien) {

            $rules["bienes.{$index}.numero_inventario"] = 'nullable|unique:biens,numero_inventario|required_without:bienes.' . $index . '.numero_serie';
            $rules["bienes.{$index}.numero_serie"] = 'nullable|unique:biens,numero_serie|required_without:bienes.' . $index . '.numero_inventario';
            // $rules["bienes.{$index}.numero_inventario"] = 'nullable|unique:biens,numero_inventario';
            // $rules["bienes.{$index}.numero_serie"] = 'nullable|unique:biens,numero_serie';
            $rules["bienes.{$index}.descripcion"] = 'required|string|max:255';
            $rules["bienes.{$index}.modelo"] = 'required|string|max:255';
            $rules["bienes.{$index}.marca"] = 'required|string|max:255';
            $rules["bienes.{$index}.precio"] = 'nullable|numeric';
            $rules["bienes.{$index}.observaciones"] = 'nullable|string|max:1000';
        }


        return $rules;
    }

    // Regla personalizada para asegurarse de que al menos uno de los campos esté presente
    //  $rules["bienes.{$index}.numero_inventario_numero_serie"] = 'required_without_all:bienes.{$index}.numero_inventario,bienes.{$index}.numero_serie';

    public function messages()
    {
        $messages = [];

        // Iteramos sobre cada bien y establecemos los mensajes de validación personalizados para cada campo
        foreach ($this->bienes as $index => $bien) {
            $tagerror = $index + 1;
            $messages["bienes.{$index}.numero_inventario.unique"] = "El número de inventario {$bien['numero_inventario']} ya ha sido tomado.";
            $messages["bienes.{$index}.numero_serie.unique"]      = "El número de serie {$bien['numero_serie']} ya ha sido tomado.";

            $messages["bienes.{$index}.precio.numeric"] = "Bien: #{$tagerror}. El Precio: {$bien['precio']} debe de ser solo numeros";

            $messages["bienes.{$index}.descripcion.required"] = "Agregue una descripcion al bien #{$tagerror}";
            $messages["bienes.{$index}.modelo.required"]      = "Agregue el modelo al bien #{$tagerror}";
            $messages["bienes.{$index}.marca.required"]       = "Agregue la marca al bien #{$tagerror}";

            // Mensajes personalizados para las reglas de required_without
            $messages["bienes.{$index}.numero_inventario.required_without"] = "Ingrese numero de inventario o numero de serie en el bien #{$tagerror}.";
            $messages["bienes.{$index}.numero_serie.required_without"]      = "Ingrese numero de serie o numero de inventario en el bien #{$tagerror}.";
        }

        // Agregamos otros mensajes de validación personalizados si es necesario
        //$messages['factura.required'] = 'El campo factura es obligatorio.';
        $messages['fecha_ingreso.required'] = 'El campo fecha de ingreso es obligatorio.';

        return $messages;
    }


    public function addBien()
    {
        $this->bienes[] = [
            'numero_inventario' => '',
            'numero_serie' => '',
            'descripcion' => '',
            'modelo' => '',
            'marca' => '',
            'precio' => 0, // Inicializar como null
            'observaciones' => '',
        ];
    }
    // public function addBien()
    // {
    //     try {
    //         // Valida los campos requeridos
    //         $this->validate();

    //         // Verifica si al menos uno de los dos campos 'numero_serie' o 'numero_inventario' está lleno
    //         // if (empty($this->numero_serie) && empty($this->numero_inventario)) {
    //         //     throw new \Exception("Debe ingresar un número de serie o un número de inventario.");
    //         // }

    //         // Crear un array para verificar duplicados
    //         $inventarioExistente = array_column($this->bienes, 'numero_inventario');
    //         $serieExistente = array_column($this->bienes, 'numero_serie');

    //         // Validar si el número de inventario o de serie ya existe en la lista actual de bienes
    //         if (in_array($this->numero_inventario, $inventarioExistente)) {
    //             throw new \Exception("Número de inventario repetido: {$this->numero_inventario}");
    //         }

    //         if (in_array($this->numero_serie, $serieExistente)) {
    //             throw new \Exception("Número de serie repetido: {$this->numero_serie}");
    //         }

    //         // Si la validación pasa, agrega el bien a la lista o realiza la acción necesaria
    //         $this->bienes[] = [
    //             'numero_inventario' => '',
    //             'numero_serie' => '',
    //             'descripcion' => '',
    //             'modelo' => '',
    //             'marca' => '',
    //             'precio' => 0, // Inicializar como null
    //             'observaciones' => '',
    //         ];



    //         // // Resetea los campos para permitir la entrada de un nuevo bien
    //         // $this->resetBien();


    //     } catch (\Exception $e) {
    //         // Mostrar un mensaje de error
    //         $this->dispatch('swal', [
    //             'title' => 'Error!',
    //             'text' => $e->getMessage(),
    //             'icon' => 'warning',
    //         ]);
    //     }
    // }



    #[On('go-submit')]
    public function submit()
    {
        try {
            // Validar los datos
            $this->validate();

            // Crear un array para verificar duplicados
            $inventarioExistente = [];
            $serieExistente = [];
            $bienesDatos = [];

            foreach ($this->bienes as $index => $bien) {
                if (in_array($bien['numero_inventario'], $inventarioExistente)) {
                    throw new \Exception("Número de inventario repetido: {$bien['numero_inventario']} en el bien #" . ($index + 1));
                }
                if (in_array($bien['numero_serie'], $serieExistente)) {
                    throw new \Exception("Número de serie repetido: {$bien['numero_serie']} en el bien #" . ($index + 1));
                }

                // Agregar a los arrays para la siguiente verificación
                if (!empty($bien['numero_inventario'])) {
                    $inventarioExistente[] = $bien['numero_inventario'];
                }
                if (!empty($bien['numero_serie'])) {
                    $serieExistente[] = $bien['numero_serie'];
                }

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

            // Crear un nuevo movimiento con el folio generado y la cantidad de bienes
            $cantidadBienes = count($this->bienes);

            // Generar un folio único
            do {
                $folio = bin2hex(random_bytes(4)); // 4 bytes producen 8 caracteres hexadecimales
            } while (Movimiento::where('folio', $folio)->exists());

            // Convertir los datos de los bienes a JSON
            $datosBienesJSON = json_encode($bienesDatos);

            // Crear un nuevo movimiento con el folio generado
            $this->crearMovimiento($folio, $cantidadBienes, $datosBienesJSON);

            // Iterar sobre cada bien y guardarlo en la base de datos
            foreach ($this->bienes as $bien) {
                $nuevoBien = new Bien();
                $nuevoBien->numero_inventario = $bien['numero_inventario'];
                $nuevoBien->numero_serie = $bien['numero_serie'];
                $nuevoBien->descripcion = $bien['descripcion'];
                $nuevoBien->modelo = $bien['modelo'];
                $nuevoBien->marca = $bien['marca'];
                $nuevoBien->precio = isset($bien['precio']) && $bien['precio'] !== '' ? $bien['precio'] : 0;

                //$nuevoBien->precio = $bien['precio'] ?? 0; // Valor predeterminado si precio está vacío
                $nuevoBien->observaciones = $bien['observaciones'];
                $nuevoBien->factura = $this->factura; // Asignamos el número de factura al bien
                $nuevoBien->fecha_ingreso = $this->fecha_ingreso; // Asignamos la fecha de ingreso al bien
                $nuevoBien->save();

                // Asociamos el bien al movimiento en la tabla pivote con el mismo folio
                $this->asociarBienAMovimiento($nuevoBien, $folio);
            }

            // Limpiamos los campos del formulario
            $this->reset();

            // Disparamos el evento 'bienAgregado'
            $this->dispatch('bienAgregado');
            $this->dispatch('movimientoAgregado');

            // Mostrar un mensaje de éxito
            $this->dispatch('swal', [
                'title' => 'Correcto!',
                'text' => 'Bien(es) agregados exitosamente!',
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
            // Mostrar un mensaje de error (puedes usar SweetAlert o cualquier otro método)
            // Si hay otros errores de validación, mostrar el primer mensaje de error
            $this->dispatch('swal', [
                'title' => 'Error!',
                'text' => $e->validator->errors()->first(),
                'icon' => 'error',
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


    // public function confirm()
    // {
    //     $this->dispatch('swalConfirmation');
    // }

    public function removeBien($index)
    {
        unset($this->bienes[$index]);
        $this->bienes = array_values($this->bienes);
    }

    public function render()
    {
        return view('livewire.bienes.crear-dinamico');
    }



    public function closeModal()
    {
        // Restablecer los campos del formulario a sus valores por defecto
        // $this->reset([
        //     'factura',
        //     'fecha_ingreso',
        //     'bienes',
        // ]);
        $this->reset(['bienes']);

        // Cerrar el modal
        $this->open = false;

        // Enviar mensaje de SweetAlert
        $this->dispatch('swal', [
            'title' => 'Atención',
            'text' => 'No se guardaron los cambios.',
            'icon' => 'info',
        ]);
    }
}
