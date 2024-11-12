<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    {{-- @livewire('crearbienes') --}}
    {{-- @livewire('crear.bienes-dinamico') --}}
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full sm:px-6 lg:px-8 bg-gray-200">
                <div class="overflow-hidden rounded-lg shadow-md bg-gray-200 ">
                    <h1 class="px-6 pt-3 text-center text-2xl font-bold text-gray-800 tracking-wider">
                        Lista de Bienes</h1>
                    <div class="mr-4 mb-2 flex justify-end">
                        {{-- <input type="text" wire:model.live="search" placeholder="Buscar..."
                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-64 p-2 rounded-md"> --}}
                        {{-- <input type="search" wire:model.live="search" placeholder="Buscar..."
                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-64 p-2 rounded-md"> --}}
                        <div class="flex justify-between">
                            <div class="flex items-center">
                                <input type="text" wire:model.live="search" placeholder="Buscar..."
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-64 p-2 rounded-md mr-4">
                                <select class="pl-2 pr-8 rounded-md py-2 mr-4" wire:model.live="paginateDinamico">
                                    <option value="10">10</option>
                                    <option value="5">5</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                    </div>



                    <table class="min-w-full w-full divide-y divide-gray-200">
                        <thead class="bg-gray-300">
                            <tr>

                                <th scope="col"
                                    class="px-3 py-3 text-center text-sm font-medium text-black tracking-wider">
                                    Descripción
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-center text-sm bold font-medium text-black tracking-wider">
                                    Modelo
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-center text-sm font-medium text-black tracking-wider">
                                    Marca
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-center text-sm font-medium text-black tracking-wider">
                                    Número de inventario
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-center text-sm font-medium text-black tracking-wider">
                                    Número de serie
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-center text-sm font-medium text-black tracking-wider">
                                    Estado
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-center text-sm font-medium text-black tracking-wider">
                                    Fecha de Ingreso
                                </th>

                                <th scope="col"
                                    class="px-3 py-3 text-center text-sm font-medium text-black tracking-wider">

                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($bienes as $bien)
                                <tr class="hover:bg-gray-100" wire:key="{{ $bien->id }}">

                                    <td
                                        class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                        {{ $bien->descripcion }}
                                    </td>
                                    <td
                                        class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                        {{ $bien->modelo }}
                                    </td>
                                    <td
                                        class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                        {{ $bien->marca }}
                                    </td>
                                    <td
                                        class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                        @if ($bien->numero_inventario)
                                            {{ $bien->numero_inventario }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td
                                        class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center">

                                        @if ($bien->numero_serie)
                                            {{ $bien->numero_serie }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td
                                        class="px-3 py-3 whitespace-nowrap text-sm font-medium text-center 
                                        @if ($bien->estado === 'DISPONIBLE') bg-green-400
                                        @elseif ($bien->estado === 'RESGUARDO') bg-red-400
                                        @elseif ($bien->estado === 'BAJA') bg-gray-400
                                        @elseif ($bien->estado === 'MANTENIMIENTO') bg-yellow-400 @endif
                                        text-gray-900">
                                        <a href="{{ route('bienes.detalle', ['id' => $bien->id]) }}"
                                            class="text-gray-900 hover:text-blue-500 hover:underline">
                                            {{ $bien->estado }}
                                        </a>
                                    </td>
                                    <td
                                        class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                        {{ \Carbon\Carbon::parse($bien->fecha_ingreso)->format('d-m-Y') }}
                                    </td>
                                    <td
                                        class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                        <div class="">
                                            <x-button class="bg-green-500 px-1"
                                                wire:click="openModalView({{ $bien->id }})"><svg
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-5 h-5">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z"
                                                        clip-rule="evenodd" />
                                                </svg>

                                            </x-button>
                                            <x-button wire:click="openModalhistorial({{ $bien->id }})"
                                                class=" bg-slate-600 px-1"><svg xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                                    <path fill-rule="evenodd"
                                                        d="M15.988 3.012A2.25 2.25 0 0 1 18 5.25v6.5A2.25 2.25 0 0 1 15.75 14H13.5V7A2.5 2.5 0 0 0 11 4.5H8.128a2.252 2.252 0 0 1 1.884-1.488A2.25 2.25 0 0 1 12.25 1h1.5a2.25 2.25 0 0 1 2.238 2.012ZM11.5 3.25a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 .75.75v.25h-3v-.25Z"
                                                        clip-rule="evenodd" />
                                                    <path fill-rule="evenodd"
                                                        d="M2 7a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7Zm2 3.25a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Zm0 3.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </x-button>

                                         {{--   @role('admin')  --}}
                                                @if ($bien->estado === 'RESGUARDO')
                                                    <x-button class="bg-sky-700 px-1 opacity-50" disabled
                                                        wire:click="openModal({{ $bien->id }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5">
                                                            <path
                                                                d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                                            <path
                                                                d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                                        </svg>
                                                    </x-button>

                                                    <x-button wire:click="openModalEstado({{ $bien->id }})"
                                                        class="bg-red-500 px-1 opacity-50" disabled><svg
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5">
                                                            <path fill-rule="evenodd"
                                                                d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                                                clip-rule="evenodd" />
                                                        </svg>

                                                    </x-button>
                                                @else
                                                    <x-button class="bg-sky-700 px-1"
                                                        wire:click="openModal({{ $bien->id }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5">
                                                            <path
                                                                d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                                            <path
                                                                d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                                        </svg>
                                                    </x-button>

                                                    <x-button wire:click="openModalEstado({{ $bien->id }})"
                                                        class="bg-red-500 px-1"><svg xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                                            <path fill-rule="evenodd"
                                                                d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                                                clip-rule="evenodd" />
                                                        </svg>

                                                    </x-button>
                                                @endif
                                          {{--  @endrole  --}}



                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>



                    <!-- Modal de edición -->
                    <x-dialog-modal wire:model="showModal">
                        <x-slot name="title">
                            Editar Bien
                        </x-slot>

                        {{-- <x-slot name="content">
                            <!-- Aquí coloca los campos de edición del bien -->
                            <!-- Por ejemplo: -->
                            <div class="container mx-auto my-auto p-8 bg-gray-100 max-h-[400px] overflow-y-auto">
                                <label for="edit_factura"
                                    class="block my-2 text-sm font-medium text-gray-900">Factura</label>
                                <input type="text" wire:model="edit_factura" id="edit_factura"
                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">

                                <label for="edit_numero_inventario"
                                    class="block my-2 text-sm font-medium text-gray-900">Número de Inventario</label>
                                <input type="text" wire:model="edit_numero_inventario" id="edit_numero_inventario"
                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @error('edit_numero_inventario')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror

                                <label for="edit_numero_serie"
                                    class="block my-2 text-sm font-medium text-gray-900">Número
                                    de Serie</label>
                                <input type="text" wire:model="edit_numero_serie" id="edit_numero_serie"
                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @error('edit_numero_serie')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror

                                <label for="edit_descripcion"
                                    class="block my-2 text-sm font-medium text-gray-900">Descripción</label>
                                <input type="text" wire:model="edit_descripcion" id="edit_descripcion"
                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @error('edit_descripcion')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror

                                <label for="edit_modelo"
                                    class="block my-2 text-sm font-medium text-gray-900">Modelo</label>
                                <input type="text" wire:model="edit_modelo" id="edit_modelo"
                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @error('edit_modelo')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror

                                <label for="edit_marca"
                                    class="block my-2 text-sm font-medium text-gray-900">Marca</label>
                                <input type="text" wire:model="edit_marca" id="edit_marca"
                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @error('edit_marca')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror

                                <label for="edit_precio"
                                    class="block my-2 text-sm font-medium text-gray-900">Precio</label>
                                <input type="text" wire:model="edit_precio" id="edit_precio"
                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @error('edit_precio')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror

                                <label for="edit_observaciones"
                                    class="block mb-2 pt-3 text-sm font-medium text-gray-900">Observaciones
                                    (opcional)</label>
                                <textarea wire:model="edit_observaciones" id="edit_observaciones" rows="4"
                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                                @error('edit_observaciones')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>


                        </x-slot> --}}

                        <x-slot name="content">
                            <!-- Aquí coloca los campos de edición del bien -->
                            <!-- Por ejemplo: -->
                            <div class="container mx-auto my-auto p-8 bg-gray-100 max-h-[500px] overflow-y-auto">
                                <div class="bg-pink-300 p-3 rounded-md mb-4">
                                    <label for="edit_factura"
                                        class="block my-2 text-sm font-medium text-gray-900">Factura</label>
                                    <input type="text" wire:model="edit_factura" id="edit_factura"
                                        class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>
                                {{-- <label for="edit_factura"
                                    class="block my-2 text-sm font-medium text-gray-900">Factura</label>
                                <input type="text" wire:model="edit_factura" id="edit_factura"
                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"> --}}

                                <div class="bg-white rounded-md shadow-md mb-4">
                                    <div class="p-4">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label for="edit_numero_inventario"
                                                    class="block my-2 text-sm font-medium text-gray-900">Número de
                                                    Inventario</label>
                                                <input type="text" wire:model="edit_numero_inventario"
                                                    id="edit_numero_inventario"
                                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                @error('edit_numero_inventario')
                                                    <span class="text-red-500">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="edit_numero_serie"
                                                    class="block my-2 text-sm font-medium text-gray-900">Número
                                                    de Serie</label>
                                                <input type="text" wire:model="edit_numero_serie"
                                                    id="edit_numero_serie"
                                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                @error('edit_numero_serie')
                                                    <span class="text-red-500">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="edit_descripcion"
                                                    class="block my-2 text-sm font-medium text-gray-900">Descripción</label>
                                                <input type="text" wire:model="edit_descripcion"
                                                    id="edit_descripcion"
                                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                @error('edit_descripcion')
                                                    <span class="text-red-500">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="edit_modelo"
                                                    class="block my-2 text-sm font-medium text-gray-900">Modelo</label>
                                                <input type="text" wire:model="edit_modelo" id="edit_modelo"
                                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                @error('edit_modelo')
                                                    <span class="text-red-500">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="edit_marca"
                                                    class="block my-2 text-sm font-medium text-gray-900">Marca</label>
                                                <input type="text" wire:model="edit_marca" id="edit_marca"
                                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                @error('edit_marca')
                                                    <span class="text-red-500">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="edit_precio"
                                                    class="block my-2 text-sm font-medium text-gray-900">Precio</label>
                                                <input type="text" wire:model="edit_precio" id="edit_precio"
                                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                @error('edit_precio')
                                                    <span class="text-red-500">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="edit_observaciones"
                                                    class="block mb-2 pt-3 text-sm font-medium text-gray-900">Observaciones
                                                    (opcional)</label>
                                                <textarea wire:model="edit_observaciones" id="edit_observaciones" rows="4"
                                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                                                @error('edit_observaciones')
                                                    <span class="text-red-500">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="flex flex-col items-start">
    <label class="mb-2 text-sm font-semibold text-gray-900">Estado:</label>
    <button wire:click="setEstado('DISPONIBLE')"
        class="w-full px-3 py-2 mb-2 rounded-md text-xs font-semibold shadow-sm transition-colors duration-300
               {{ $edit_estado === 'DISPONIBLE' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
        DISPONIBLE
    </button>
    <button wire:click="setEstado('MANTENIMIENTO')"
        class="w-full px-3 py-2 rounded-md text-xs font-semibold shadow-sm transition-colors duration-300
               {{ $edit_estado === 'MANTENIMIENTO' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
        MANTENIMIENTO
    </button>
</div>




                                        </div>
                                    </div>
                                </div>
                            </div>


                        </x-slot>

                        <x-slot name="footer">
                            <x-button wire:click="closeModal">
                                Cancelar
                            </x-button>

                            {{-- <x-danger-button wire:click="updateBien" class="ml-2"> --}}
                            <x-danger-button wire:click="$dispatch('confirm-update')" class="ml-2">
                                Guardar
                            </x-danger-button>
                        </x-slot>
                    </x-dialog-modal>

                    <!-- Modal de vista -->
                    <x-dialog-modal wire:model="showModalview">
                        <x-slot name="title">
                            datos del bien
                        </x-slot>

                        <x-slot name="content">
                            <div class="p-3">

                                @if ($bienInfo)
                                    <div>
                                        <p><strong>Factura:</strong> {{ $bienInfo->factura }}</p> <br>
                                    </div>
                                    <div>
                                        <p><strong>Estatus:</strong> {{ $bienInfo->estado }}</p> <br>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 border">

                                        <div class="border p-1">
                                            <label for=""
                                                class="block mb-2 text-sm font-medium text-gray-900"><strong>Descripción:</strong></label>
                                            <p> {{ $bienInfo->descripcion }}</p>
                                        </div>
                                        <div class="border p-1">
                                            <label for=""
                                                class="block mb-2 text-sm font-medium text-gray-900"><strong>Modelo:</strong></label>
                                            <p> {{ $bienInfo->modelo }}</p>
                                        </div>
                                        <div class="border p-1">
                                            <label for=""
                                                class="block mb-2 text-sm font-medium text-gray-900"><strong>Marca:</strong></label>
                                            <p> {{ $bienInfo->marca }}</p>
                                        </div>
                                        <div class="border p-1">
                                            <label for=""
                                                class="block mb-2 text-sm font-medium text-gray-900"><strong>Número de
                                                    Inventario:</strong></label>
                                            <p>
                                                {{ $bienInfo->numero_inventario }}</p>
                                        </div>
                                        <div class="border p-1">
                                            <label for=""
                                                class="block mb-2 text-sm font-medium text-gray-900"><strong>Número de
                                                    Serie:</strong></label>
                                            <p> {{ $bienInfo->numero_serie }}</p>
                                        </div>
                                        <div class="border p-1">
                                            <label for=""
                                                class="block mb-2 text-sm font-medium text-gray-900"><strong>Precio:</strong></label>
                                            <p> {{ $bienInfo->precio }}</p>
                                        </div>

                                        <div class="border p-1">
                                            <label for=""
                                                class="block mb-2 text-sm font-medium text-gray-900"><strong>Observaciones:</strong></label>
                                            <p>
                                                @if ($bienInfo->observaciones)
                                                    {{ $bienInfo->observaciones }}
                                                @else
                                                    Sin observaciones
                                                @endif
                                            </p>
                                        </div>
                                    </div>


                                    @if ($bienInfo->estado == 'RESGUARDO')
                                        <div class="py-2 my-2 bg-orange-200 rounded-md">

                                            <div class="px-4 py-3 text-left text-gray-700">
                                                <h3 class=" font-medium tracking-wider">Bien en resguardo de:</h3>
                                                <p
                                                    class="text-left py-1 text-xl font-medium text-gray-700 uppercase tracking-wider">
                                                    RFC:
                                                    <strong>{{ $bienInfo->personal->rfc }}</strong>
                                                </p>
                                                <p
                                                    class="text-left py-1 text-xl font-medium text-gray-700 uppercase tracking-wider">
                                                    Nombre:
                                                    <strong>{{ $bienInfo->personal->nombre }}</strong>
                                                </p>
                                                <p
                                                    class="text-left py-1 text-xl font-medium text-gray-700 uppercase tracking-wider">
                                                    Área:
                                                    <strong>{{ $bienInfo->personal->area }}</strong>
                                                </p>
                                            </div>
                                        </div>
                                    @else
                                        <div class=" flex justify-center my-3 py-3 bg-gray-200 rounded-md text-xl">Sin
                                            resguardo activo</div>
                                    @endif

                                @endif

                            </div>

                        </x-slot>

                        <x-slot name="footer">
                            <x-button wire:click="closeModalView">
                                Cancelar
                            </x-button>


                        </x-slot>
                    </x-dialog-modal>

                    <!-- Modal de DELETE-->
                    <x-dialog-modal wire:model="showModalEstado">
                        <form wire:submit.prevent="updateEstado" enctype="multipart/form-data"> 
                        <x-slot name="title">
                            Baja de un bien
                        </x-slot>

                        <x-slot name="content">
                            <div class="p-4">

                                <div class="bg-gray-100 p-3 rounded-md">
                                    <label for="observaciones"
                                        class="block mb-2 text-sm font-medium text-gray-900">observaciones</label>
                                    <input type="text" wire:model="observaciones" id="observaciones"
                                        class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    @error('observaciones')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror

                                    <label for="fecha_baja"
                                        class="block mb-2 pt-2 text-sm font-medium text-gray-900">Fecha de
                                        Baja</label>
                                    <input type="date" wire:model="fecha_baja" id="fecha_baja"
                                        class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    @error('fecha_baja')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror

                                     <!-- Campo de Documento (opcional) -->
                                     <label for="documento" class="block mb-2 pt-2 text-sm font-medium text-gray-900">Documento (opcional)</label>

<!-- Ícono personalizado para cargar archivo -->
<div class="flex items-center">
    <label for="documento" class="flex items-center cursor-pointer p-2 bg-gray-100 rounded-lg hover:bg-gray-200 ring-1 ring-inset ring-gray-300 focus-within:ring-blue-500">
        <!-- Ícono de carga -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2a5 5 0 0 1 5 5v6.586l1.707-1.707a1 1 0 1 1 1.414 1.414l-4 4a1 1 0 0 1-1.414 0l-4-4a1 1 0 0 1 1.414-1.414L11 13.586V7a3 3 0 1 0-6 0v10H3V7a5 5 0 0 1 5-5h4z" />
            <path d="M17 21a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM11 21a1 1 0 1 1 2 0 1 1 0 0 1-2 0z" />
        </svg>
        <span class="ml-2 text-gray-700 text-sm">Seleccionar archivo</span>
    </label>
    
    <!-- Campo input escondido -->
    <input type="file" wire:model="documento" id="documento" accept="application/pdf" class="hidden">
</div>

<!-- Mensaje de error -->
@error('documento')
    <span class="text-red-500">{{ $message }}</span>
@enderror


                                    <label for="clave"
                                        class="block mb-2 pt-2 text-sm font-medium text-gray-900">Clave</label>
                                    <input type="password" wire:model="clave" id="clave"
                                        class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    @error('clave')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>


                        </x-slot>

                        <x-slot name="footer">
                            <x-button wire:click="closeModalEstado">
                                Cancelar
                            </x-button>

                            <x-danger-button wire:click="$dispatch('confirm-baja')" class="ml-2">
                                Guardar
                            </x-danger-button>

                        </x-slot>
                        {{-- </form> --}}
                    </x-dialog-modal>

                    <!-- Modal de HISTORIAL-->
                    <x-dialog-modal wire:model="showModalhistorial" maxWidth="6xl">
                        <x-slot name="title">
                            Historial de movimientos
                        </x-slot>

                        <x-slot name="content">

                            <div class="mb-4 flex">
                                <h2 class="text-xl font-bold pr-3">Descripción del Bien: </h2>
                                <h3 class="text-lg font-semibold">
                                    {{ $bienDescripcion }}
                                    @if ($bienInventario)
                                        (Inventario: {{ $bienInventario }})
                                    @else
                                        (Serie: {{ $bienSerie }})
                                    @endif
                                </h3>
                            </div>
                            <div class="overflow-auto max-h-[500px]">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2">Folio</th>
                                            <th class="px-4 py-2">Fecha</th>
                                            <th class="px-4 py-2">Tipo de Movimiento</th>
                                            <th class="px-4 py-2">Solicitante</th>
                                            <th class="px-4 py-2">Adscripción</th>
                                            <th class="px-4 py-2">Observaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($movimientos as $movimiento)
                                            <tr>
                                                <td
                                                    class="border px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    @if ($movimiento->tipo_moviento === 'RESGUARDO')
                                                        <a
                                                            href="{{ route('detallesFolios', ['id' => $movimiento->id]) }}">
                                                            <strong>
                                                                <p
                                                                    class="text-gray-900 hover:text-blue-500 hover:underline">
                                                                    {{ $movimiento->folio }}</p>
                                                            </strong>
                                                        </a>
                                                    @else
                                                        {{ $movimiento->folio }}
                                                    @endif
                                                </td>
                                                <td class="px-3 py-3 whitespace-nowrap text-sm font-medium border">
                                                    {{ \Carbon\Carbon::parse($movimiento->fecha)->format('d-m-Y') }}
                                                </td>
                                                <td
                                                    class="border px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $movimiento->tipo_moviento }}
                                                </td>
                                                <td
                                                    class="border px-3 py-3 whitespace-normal text-sm font-medium text-gray-900">
                                                    @if ($movimiento->personal)
                                                        {{ $movimiento->personal->nombre }}
                                                    @else
                                                        Sin solicitante
                                                    @endif
                                                </td>
                                                <td
                                                    class="border px-3 py-3 whitespace-normal text-sm font-medium text-gray-900">
                                                    @if ($movimiento->personal)
                                                        {{ $movimiento->personal->area }}
                                                    @else
                                                        Sin área
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-3 py-3 whitespace-normal text-center text-sm font-medium border">
                                                    @if ($movimiento->observaciones)
                                                        {{ $movimiento->observaciones }}
                                                    @else
                                                        Sin observaciones
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <x-button wire:click="closeModalhistorial">
                                Cerrar
                            </x-button>
                        </x-slot>
                    </x-dialog-modal>

                </div>
                <!-- Agregar el paginador -->
                <!-- Agregar el paginador -->
                <!-- Agregar el paginador -->
                <div class="my-2 mx-2">
                    {{ $bienes->links() }}
                </div>
            </div>
        </div>
    </div>

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
        @this.on('confirm-update', (event) => {
            Swal.fire({
                title: "¿Guardar bienes?",
                text: "Los bienes ingresados se daran de alta en el sistema",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, guardar",
                cancelButtonText: "Cancelar"

            }).then((result) => {
                if (result.isConfirmed) {

                    @this.dispatch('go-updateBien')


                }
            });
        })

        @this.on('confirm-baja', (event) => {
            Swal.fire({
                title: "¿Dar de baja?",
                text: "El bien se dara de baja del sistema",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, guardar",
                cancelButtonText: "Cancelar"

            }).then((result) => {
                if (result.isConfirmed) {

                    @this.dispatch('go-updateEstado')


                }
            });
        })
    })
</script>
