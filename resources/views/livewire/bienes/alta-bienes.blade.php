<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div>
        {{-- <x-button class=" bg-pink-600 py-3" wire:click="$set('open',true)">agregar bienes --}}
        <x-button class=" bg-yellow-500 py-3" wire:click="abrirModal"><svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd"
                    d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875ZM12.75 12a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V18a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V12Z"
                    clip-rule="evenodd" />
                <path
                    d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
            </svg>
        </x-button>
    </div>

    <x-dialog-modal wire:model="open" maxWidth="6xl">
        <div>
            <x-slot name="title">
                Dar Bienes de Alta
            </x-slot>

            <x-slot name="content">
                <div class="container mx-auto my-auto p-8 bg-gray-100 max-h-[600px] overflow-y-auto">
                    <!-- Información de Factura y Fecha de Ingreso -->
                    <div class="bg-pink-300 p-3 rounded-md mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="factura" class="block mb-2 text-sm font-medium text-gray-900">Factura</label>
                            <input type="text" placeholder="Opcional" wire:model="factura" id="factura"
                                class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            @error('factura')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="fecha_ingreso" class="block mb-2 text-sm font-medium text-gray-900">Fecha de
                                Ingreso</label>
                            <input type="date" wire:model="fecha_ingreso" id="fecha_ingreso"
                                class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            @error('fecha_ingreso')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <!-- Tabla temporal para mostrar los bienes agregados -->
                    <div id="tabla_bienes_x_Agregar" class="my-4">
                        @if ($bienes)
                            <h2 class="text-lg font-semibold">Bienes que se daran de alta</h2>
                            <table class="min-w-full divide-y divide-gray-200 mt-2">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            #</th>
                                        <th scope="col"
                                            class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Descripción</th>
                                        <th scope="col"
                                            class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Marca</th>
                                        <th scope="col"
                                            class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Modelo</th>
                                        <th scope="col"
                                            class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Número de Serie</th>
                                        <th scope="col"
                                            class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Número de Inventario</th>
                                        <th scope="col"
                                            class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Precio</th>
                                        <th scope="col"
                                            class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Observaciones</th>
                                        <th scope="col"
                                            class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($bienes as $bien)
                                        <tr>
                                            <td class="px-2 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                                            <td class="px-2 py-4 text-sm text-gray-900">{{ $bien['descripcion'] }}</td>
                                            <td class="px-2 py-4 text-sm text-gray-900">{{ $bien['marca'] }}</td>
                                            <td class="px-2 py-4 text-sm text-gray-900">{{ $bien['modelo'] }}</td>
                                            <td class="px-2 py-4 text-sm text-gray-900 text-center">

                                                @if ($bien['numero_serie'])
                                                    {{ $bien['numero_serie'] }}
                                                @else
                                                    S/N
                                                @endif
                                            </td>
                                            <td class="px-2 py-4 text-sm text-gray-900 text-center">

                                                @if ($bien['numero_inventario'])
                                                    {{ $bien['numero_inventario'] }}
                                                @else
                                                    S/N
                                                @endif
                                            </td>
                                            <td class="px-2 py-4 text-sm text-gray-900">

                                                @if ($bien['precio'])
                                                    {{ $bien['precio'] }}
                                                @else
                                                    S/N
                                                @endif
                                            </td>
                                            <td class="px-2 py-4 text-sm text-gray-900 whitespace-normal">

                                                @if ($bien['observaciones'])
                                                    {{ $bien['observaciones'] }}
                                                @else
                                                    Sin comentarios
                                                @endif
                                            </td>
                                            <td class="px-2 py-4 text-sm text-gray-900">
                                                <x-button type="button" class="bg-red-500 text-white p-2 rounded"
                                                    wire:click="removeBien({{ $loop->index }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-5 h-5">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </x-button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                    </div>



                    {{-- contenedor de formulario --}}
                    @if ($formVisible)
                        <div id="formulario" class="bg-white rounded-md shadow-md mb-4">
                            <div class="p-4">
                                <div class=" flex justify-center  ">
                                    <label
                                        class="rounded-md bg-pink-500 px-3 py-1 block mb-2 text-lg font-medium text-white">Formulario
                                        alta de bienes
                                        {{-- {{ $loop->iteration }} --}}
                                    </label>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="descripcion"
                                            class="block mb-2 text-sm font-medium text-gray-900">Descripción</label>
                                        <input type="text" placeholder="Requerido" wire:model="descripcion"
                                            id="descripcion"
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        @error('descripcion')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="marca"
                                            class="block mb-2 text-sm font-medium text-gray-900">Marca</label>
                                        <input type="text" placeholder="Requerido" wire:model="marca" id="marca"
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        @error('marca')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="modelo"
                                            class="block mb-2 text-sm font-medium text-gray-900">Modelo</label>
                                        <input type="text" placeholder="Requerido" wire:model="modelo" id="modelo"
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        @error('modelo')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="numero_serie"
                                            class="block mb-2 text-sm font-medium text-gray-900">Número de
                                            Serie</label>
                                        <input type="text" wire:model="numero_serie" id="numero_serie"
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        @error('numero_serie')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="numero_inventario"
                                            class="block mb-2 text-sm font-medium text-gray-900">Número de
                                            inventario</label>
                                        <input type="text" wire:model="numero_inventario" id="numero_inventario"
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        @error('numero_inventario')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="precio"
                                            class="block mb-2 text-sm font-medium text-gray-900">Precio</label>
                                        <input type="text" wire:model="precio" id="precio"
                                            placeholder="Opcional solo numeros"
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        @error('precio')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="observaciones"
                                            class="block mb-2 text-sm font-medium text-gray-900">Observaciones
                                        </label>
                                        <textarea maxlength="1000" placeholder="Opcional" wire:model="observaciones" id="observaciones" rows="4"
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                                        @error('observaciones')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="relative">
                                        <!-- Otros elementos dentro del div -->

                                        <x-button type="button"
                                            class="bg-green-500 text-white p-2 rounded absolute bottom-0 right-0"
                                            wire:click="addBien">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="size-5">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </x-button>
                                    </div>


                                </div>


                            </div>
                        </div>
                    @endif

                    <!-- boton_abrirFormulario -->
                    @if (!$formVisible)
                        <div id="boton_abrirFormulario" class="justify-center items-center py-4 space-x-2">
                            {{-- <p class=""></p> --}}
                            <label for="fecha_ingreso"
                                class="flex justify-center mb-2 text-sm text-green-700 font-semibold uppercase">Agregar
                                otro bien</label>
                            <div class="flex justify-center">
                                <x-button type="button" class=" bg-green-500 text-white p-2 rounded text-lg"
                                    wire:click="abrirFormulario">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                      </svg>
                                      
                                      

                                </x-button>
                            </div>

                        </div>
                    @endif


                    {{-- @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif --}}
                    {{-- Botón de Guardar --}}
                    {{-- <button type="submit">Guardar</button> --}}
                </div>
            </x-slot>

            <x-slot name="footer" class=" justify-between">
                {{-- <x-button wire:click="$set('open',false)" wire:loading.attr="disabled"> --}}
                <x-button wire:click="$set('open',false)" wire:loading.attr="disabled" {{-- wire:confirm="No se guardara lo ingresado" --}}>
                    Cerrar
                </x-button>



                <x-danger-button type="submit" class="ml-2" wire:click="$dispatch('submitAltas-prompt')"
                    wire:loading.attr="disabled">
                    dar de alta
                </x-danger-button>


            </x-slot>
        </div>

    </x-dialog-modal>
</div>
