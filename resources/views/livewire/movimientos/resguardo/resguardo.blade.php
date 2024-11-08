<div wire:ignore.self>
    <div>
        <x-button class="bg-yellow-500 py-3" wire:click="$set('open',true)">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd"
                    d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875ZM12.75 12a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V18a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V12Z"
                    clip-rule="evenodd" />
                <path
                    d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
            </svg>


        </x-button>
    </div>

    {{-- <form wire:submit.prevent="submit"> --}}
    <x-dialog-modal wire:model="open" maxWidth="4xl">
        <x-slot name="title">
            Formulario de prestamo de equipos informaticos
        </x-slot>

        <x-slot name="content">
            <div class="container mx-auto my-auto p-8 max-h-[600px] bg-gray-100 overflow-y-auto">
                <label for="$selected_personal" class="block mb-2 text-lg font-medium text-gray-900">Selección de
                    solicitante</label>
                <x-input class="mb-3 block w-full" wire:model.live="terminoBusquedaPersonals" type="text"
                    placeholder="Buscar personal..." />

                @if ($selected_personal)
                    <table class="my-2 py-4 w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-2 py-2">Solicitante</th>
                                <th class="px-2 py-2">Adscripción</th>
                                <th class="px-2 py-2"></th>
                                <!-- Agregar más columnas según sea necesario -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-2 py-2 text-center">{{ $selected_personal->nombre }}</td>
                                <td class="px-2 py-2 text-center"> {{ $selected_personal->area }}</td>
                                <td class="px-2 py-2 text-center">
                                    <x-button class="bg-red-500 ml-4" wire:click="clearSelection">X
                                    </x-button>
                                </td>
                                <!-- Agregar más celdas según sea necesario -->
                            </tr>
                        </tbody>
                    </table>
                    <div class="pt-4">
                        {{-- <p class="mb-4 mt-4">Búsqueda de bienes</p> --}}
                        <label for="selectBien" class="block mb-2 text-lg font-medium text-gray-900">Búsqueda de bienes</label>

                        <x-input class="mb-3 block w-full" wire:model.live="terminoBusquedaBienes" type="text"
                            placeholder="Buscar bienes..." />
                        @if ($terminoBusquedaBienes)
                            @if ($bienes->isEmpty())
                                <p class="text-center mt-2">Sin coincidencias</p>
                            @else
                                <table class="mt-2 mb-4 w-full border-collapse border border-gray-300">
                                    <thead class="bg-gray-200">
                                        <tr>
                                            <th class="px-2 py-2"></th>
                                            <th class="px-2 py-2">Descripción</th>
                                            <th class="px-2 py-2">Marca</th>
                                            <th class="px-2 py-2">Modelo</th>
                                            <th class="px-2 py-2">Número de Inventario</th>
                                            <th class="px-2 py-2">Número de Serie</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bienes as $b)
                                            <tr>
                                                <td class="px-2 py-2 text-center">
                                                    @if (!in_array($b->id, $selected_bienes))
                                                        <x-input type="checkbox"
                                                            wire:click="selectBien({{ $b->id }})"
                                                            class="mr-2" />
                                                    @else
                                                        <x-input type="checkbox" disabled class="mr-2" />
                                                    @endif
                                                </td>
                                                <td class="px-2 py-2 text-center">{{ $b->descripcion }}</td>
                                                <td class="px-2 py-2 text-center">{{ $b->marca }}</td>
                                                <td class="px-2 py-2 text-center">{{ $b->modelo }}</td>
                                                <td class="px-2 py-2 text-center">
                                                    @if ($b->numero_inventario)
                                                        {{ $b->numero_inventario }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="px-2 py-2 text-center">

                                                    @if ($b->numero_serie)
                                                        {{ $b->numero_serie }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @else
                            <p class="mb-4 mt-4">Ingresa un término para buscar bienes</p>
                        @endif


                        @if (count($selected_bienes) > 0)
                            <div>
                                <div class=" bg-slate-300 ">
                                    <h2 class="flex justify-center text-lg font-bold">LISTA DE BIENES A RESGUARDAR</h2>
                                </div>
                                <ul>
                                    <table class="mb-4 w-full border-collapse border border-gray-300">
                                        <thead class="bg-gray-200">
                                            <tr>
                                                <th class="p-2">Descripcion</th>
                                                <th class="p-2">Marca</th>
                                                <th class="p-2">Modelo</th>
                                                <th class="p-2">Número de Inventario</th>
                                                <th class="p-2">Número de Serie</th>

                                                <th class="p-2"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($selected_bienes as $index => $bienId)
                                                @php
                                                    // Obtener el bien correspondiente al ID
                                                    $bien = App\Models\Bien::find($bienId);
                                                @endphp
                                                @if ($bien)
                                                    {{-- <div class="flex justify-end font-bold text-lg ml-4 my-2"> --}}
                                                    <div>

                                                        <tr>
                                                            <td class="p-2 text-center">{{ $bien->descripcion }}</td>
                                                            <td class="p-2 text-center">{{ $bien->marca }}</td>
                                                            <td class="p-2 text-center">{{ $bien->modelo }}</td>
                                                            <td class="p-2 text-center">
                                                                @if ($bien->numero_inventario)
                                                                    {{ $bien->numero_inventario }}
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                            <td class="p-2 text-center">
                                                                @if ($bien->numero_serie)
                                                                    {{ $bien->numero_serie }}
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>

                                                            <td class="p-2 text-center">
                                                                <x-button class="bg-red-500 ml-4"
                                                                    wire:click="removeBien({{ $index }})">x</x-button>
                                                            </td>
                                                        </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </ul>
                            </div>
                        @endif
                    </div>


                    <div>
                        <div class="mt-3">
                            <label for="observacion" class="block my-2 text-sm font-medium text-gray-900">Observación
                                (opcional)</label>
                            <textarea type="text" wire:model="observacion" id="observacion"
                                class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                            @error('observacion')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label for="fecha" class="block my-2 text-sm font-medium text-gray-900">Fecha</label>
                            <input type="date" wire:model="fecha" id="fecha"
                                class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                min="{{ $fecha_minima }}">
                        </div>
                        @error('fecha')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        {{-- </div> --}}
                    </div>
                @else
                    @if ($terminoBusquedaPersonals)

                        <ul>
                            @foreach ($personal as $p)
                                <li class="font-bold text-lg ml-4">
                                    {{-- <x-input type="checkbox" wire:model="selected_personal_id"
                                        value="{{ $p->id }}" wire:change="selectPersonal({{ $p->id }})"
                                        class="mr-2" /> --}}
                                    <x-input type="checkbox" value="{{ $p->id }}"
                                        wire:change="selectPersonal({{ $p->id }})" class="mr-2" />
                                    {{ $p->nombre }} - {{ $p->area }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="mb-8 text-center">Busqueda de personal</p>
                    @endif


                    <!-- Buscar y seleccionar bienes -->
                @endif

            </div>


        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$set('open',false)" wire:loading.attr="disabled">
                Cerrar
            </x-button>

            {{-- <x-danger-button type="submit" class="ml-2" wire:loading.attr="disabled"> --}}
            {{-- <x-danger-button wire:click="submit" class="ml-2" wire:loading.attr="disabled">
                guardar
            </x-danger-button> --}}
            <x-danger-button wire:click="$dispatch('confirm-prestamo')" class="ml-2" wire:loading.attr="disabled">
                guardar
            </x-danger-button>

        </x-slot>
    </x-dialog-modal>

    {{-- </form> --}}
</div>
