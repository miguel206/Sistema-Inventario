<div>
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

    {{-- <form wire:submit.prevent="submit"> --}}
    <x-dialog-modal wire:model="open" maxWidth="2xl">
        <div>
            <x-slot name="title">
                Dar Bienes de Alta
            </x-slot>

            <x-slot name="content">
                <div class="container mx-auto my-auto p-8 bg-gray-100 max-h-[600px] overflow-y-auto">
                    <!-- Información de Factura y Fecha de Ingreso -->
                    <div class="bg-pink-300 p-3 rounded-md mb-4">
                        <label for="factura" class="block mb-2 text-sm font-medium text-gray-900">Factura</label>
                        <input type="text" wire:model="factura" id="factura"
                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        @error('factura')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror

                        <label for="fecha_ingreso" class="block mb-2 text-sm font-medium text-gray-900">Fecha de
                            Ingreso</label>
                        <input type="date" wire:model="fecha_ingreso" id="fecha_ingreso"
                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        @error('fecha_ingreso')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Lista de Bienes -->
                    @foreach ($bienes as $index => $bien)
                        <div class="bg-white rounded-md shadow-md mb-4">
                            <div class="p-4">
                                <div class=" flex justify-center  ">
                                    <label
                                        class="rounded-md bg-pink-300 px-3 py-1 block mb-2 text-lg font-medium text-gray-900">Bien
                                        #{{ $loop->iteration }}</label>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="descripcion_{{ $index }}"
                                            class="block mb-2 text-sm font-medium text-gray-900">Descripción</label>
                                        <input type="text" wire:model="bienes.{{ $index }}.descripcion"
                                            id="descripcion_{{ $index }}"
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        @error('bienes.' . $index . '.descripcion')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="marca_{{ $index }}"
                                            class="block mb-2 text-sm font-medium text-gray-900">Marca</label>
                                        <input type="text" wire:model="bienes.{{ $index }}.marca"
                                            id="marca_{{ $index }}"
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        @error('bienes.' . $index . '.marca')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="modelo_{{ $index }}"
                                            class="block mb-2 text-sm font-medium text-gray-900">Modelo</label>
                                        <input type="text" wire:model="bienes.{{ $index }}.modelo"
                                            id="modelo_{{ $index }}"
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        @error('bienes.' . $index . '.modelo')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="numero_serie_{{ $index }}"
                                            class="block mb-2 text-sm font-medium text-gray-900">Número de
                                            Serie</label>
                                        <input type="text" wire:model="bienes.{{ $index }}.numero_serie"
                                            id="numero_serie_{{ $index }}"
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        @error('bienes.' . $index . '.numero_serie')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="numero_inventario_{{ $index }}"
                                            class="block mb-2 text-sm font-medium text-gray-900">Número de
                                            inventario</label>
                                        <input type="text" wire:model="bienes.{{ $index }}.numero_inventario"
                                            id="numero_inventario_{{ $index }}"
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        @error('bienes.' . $index . '.numero_inventario')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="precio_{{ $index }}"
                                            class="block mb-2 text-sm font-medium text-gray-900">Precio</label>
                                        <input type="text" wire:model="bienes.{{ $index }}.precio"
                                            id="precio_{{ $index }}" placeholder="Opcional"
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        @error('bienes.' . $index . '.precio')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="observaciones_{{ $index }}"
                                            class="block mb-2 text-sm font-medium text-gray-900">Observaciones
                                        </label>
                                        <textarea maxlength="1000" placeholder="Opcional" wire:model="bienes.{{ $index }}.observaciones"
                                            id="observaciones_{{ $index }}" rows="4"
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                                        @error('bienes.' . $index . '.observaciones')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Botón de Eliminar Bien (solo si hay más de un bien) -->
                                @if (count($bienes) > 1)
                                    <div class="flex justify-end items-center p-1 space-x-2">
                                        <p class="text-red-700 font-semibold uppercase">Eliminar bien
                                            #{{ $loop->iteration }}</p>
                                        <x-button type="button" class="bg-red-500 text-white p-2 rounded"
                                            wire:click="removeBien({{ $index }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-5 h-5">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </x-button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <!-- Botón de Agregar Bien -->
                    <div class="flex justify-start items-center p-1 space-x-2">

                        <x-button type="button" class="bg-green-500 text-white p-2 rounded" wire:click="addBien">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11.25a.75.75 0 0 0-1.5 0v2.5h-2.5a.75.75 0 0 0 0 1.5h2.5v2.5a.75.75 0 0 0 1.5 0v-2.5h2.5a.75.75 0 0 0 0-1.5h-2.5v-2.5Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </x-button>
                        
                        <p class="text-green-700 font-semibold uppercase">Agregar otro bien</p>
                    </div>

                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    {{-- Botón de Guardar --}}
                    {{-- <button type="submit">Guardar</button> --}}
                </div>
            </x-slot>

            <x-slot name="footer" class=" justify-between">
                {{-- <x-button wire:click="$set('open',false)" wire:loading.attr="disabled"> --}}
                <x-button wire:click="closeModal" wire:loading.attr="disabled"
                    wire:confirm="No se guardara lo ingresado">
                    Cerrar
                </x-button>

                {{-- <x-button wire:click="$dispatch('delete-prompt')" wire:loading.attr="disabled">
                        Cerrar
                    </x-button> --}}

                <x-danger-button type="submit" class="ml-2" wire:click="$dispatch('delete-prompt')"
                    wire:loading.attr="disabled">
                    dar de alta
                </x-danger-button>


            </x-slot>
        </div>

    </x-dialog-modal>
    {{-- </form> --}}


</div>
<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('swal', (event) => {
            //alert('123')
            const data = event
            Swal.fire({
                title: data[0]['title'],
                text: data[0]['text'],
                icon: data[0]['icon'],
            });
        })
        // @this.on('delete-prompt', (event) => {
        //     Swal.fire({
        //         title: "¿Guardar lista de bienes?",
        //         text: "los bienes ingresados se agregaran al inventario",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         confirmButtonText: "Si, guardar"
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             Swal.fire({
        //                 title: "Registro correcto",
        //                 text: "Se dio de alta los bienes en el sistema",
        //                 icon: "success"
        //             });
        //         }
        //     });
        // })
        // @this.on('swalConfirmation', (event) => {
        //     //alert('123')
        //     const data = event
        //     Swal.fire({
        //         title: "Are you sure?",
        //         text: "You won't be able to revert this!",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         confirmButtonText: "Yes, delete it!"
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             Swal.fire({
        //                 title: "Deleted!",
        //                 text: "Your file has been deleted.",
        //                 icon: "success"
        //             });
        //         }
        //     });
        // })
    })
</script>
