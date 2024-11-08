<div>
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
            Formulario de Devolución de Bienes
        </x-slot>

        <x-slot name="content">
            <!-- Sección para seleccionar el personal que está devolviendo los bienes -->
            <div>
                <label class=" mb-4" for="searchPersonal">Buscar Personald:</label>
                <x-input class="mb-3 block w-full" wire:model.live="searchPersonal" type="text" id="searchPersonal"
                    placeholder="Buscar personal..." />
                @if ($selectedPersonal)
                    <div class="flex justify-end font-bold text-lg ml-4">
                        <table class="mt-2 w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-2 py-2">Solicitante</th>
                                    <th class="px-2 py-2">Area</th>
                                    <th class="px-2 py-2"></th>
                                    <!-- Agregar más columnas según sea necesario -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-2 py-2 text-center">{{ $selectedPersonal->nombre }}</td>
                                    <td class="px-2 py-2 text-center"> {{ $selectedPersonal->area }}</td>
                                    <td class="px-2 py-2 text-center">
                                        <x-button class="bg-red-500 ml-4"
                                            wire:click="clearSelection">Eliminar</x-button>
                                    </td>
                                    <!-- Agregar más celdas según sea necesario -->
                                </tr>
                            </tbody>
                        </table>
                        {{-- {{ $selectedPersonal->nombre }} - {{ $selectedPersonal->area }}
                        <x-button class="bg-red-500 ml-4" wire:click="clearSelection">Eliminar</x-button> --}}
                    </div>
                @endif
                @if ($searchPersonal)
                    <div class="mt-3">
                        <ul>
                            @foreach ($personal as $p)
                                <li class="font-bold text-lg ml-4">
                                    <x-input type="checkbox" wire:model="selectedPersonal" value="{{ $p->id }}"
                                        wire:change="selectPersonal({{ $p->id }})" class="mr-2" />
                                    {{ $p->nombre }} - {{ $p->area }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Complementos del formulario para observación y fecha -->
            @if ($selectedPersonal)

                {{-- //tabla de bienes en resguardo. --}}
                <div class="mt-4">
                    <h2 class="font-bold text-lg">Bienes resguardados
                        <x-button class="ml-4 bg-blue-500" wire:click="selectAll">Seleccionar Todos</x-button>
                    </h2>
                    @if ($bienesResguardo->count() > 0)
                        <table class="mt-2 w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-2 py-2"></th>
                                    <th class="px-2 py-2">Folio</th>
                                    <th class="px-2 py-2">Descripción</th>
                                    <th class="px-2 py-2">Modelo</th>
                                    <th class="px-2 py-2">Número de Inventario</th>
                                    <th class="px-2 py-2">Número de Serie</th>
                                    <!-- Agregar más columnas según sea necesario -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bienesResguardo as $bien)
                                    <tr>
                                        <td class="px-2 py-2 text-center">
                                            <x-input type="checkbox" wire:model="selectedBienes"
                                                value="{{ $bien->id }}" />
                                        </td>
                                        <td class="px-2 py-2 text-center">
                                            {{ $bien->movimientosResguardo->first()->folio ?? 'N/A' }}</td>
                                        <td class="px-2 py-2 text-center">{{ $bien->descripcion }}</td>
                                        <td class="px-2 py-2 text-center">{{ $bien->modelo }}</td>
                                        <td class="px-2 py-2 text-center">{{ $bien->numero_inventario }}</td>
                                        <td class="px-2 py-2 text-center">{{ $bien->numero_serie }}</td>
                                        <!-- Agregar más celdas según sea necesario -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No hay bienes bajo resguardo de este personal.</p>
                    @endif
                </div>

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
                    @error('fecha')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            @endif

        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$set('open',false)" wire:loading.attr="disabled">
                Cerrar
            </x-button>

            {{-- <x-danger-button type="submit" class="ml-2" wire:loading.attr="disabled"> --}}
            {{-- <x-danger-button wire:click="submit2" class="ml-2" wire:loading.attr="disabled"> --}}
                <x-danger-button wire:click="$dispatch('confirm-devolucion')" class="ml-2" wire:loading.attr="disabled">
                devolver
            </x-danger-button>

        </x-slot>
    </x-dialog-modal>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
</div>
