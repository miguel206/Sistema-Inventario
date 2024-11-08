<div>
    <div>
        <x-button class="bg-pink-600 py-3" wire:click="$set('open',true)">
            Cancelar
        </x-button>
    </div>

    {{-- <form wire:submit.prevent="submit"> --}}
    <x-dialog-modal wire:model="open" maxWidth="4xl">
        <x-slot name="title">
            CANCELAR UN RESGUARDO
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-input type="text" wire:model.live="searchFolio" placeholder="Buscar por folio..."
                    class="block w-full" />
            </div>

            @if ($searchFolio)
                <div class="mb-4">
                    <ul>
                        @foreach ($searchResults as $result)
                            <li class="mb-2">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:click="selectFolio({{ $result->id }})"
                                        {{ $selectedFolio && $selectedFolio->id == $result->id ? 'checked' : '' }} >
                                    <span class="ml-2">{{ $result->folio }}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                    {{ $searchResults->links() }}
                </div>
            @endif

            @if ($selectedFolio)
                <div class="mb-4">
                    <div class="flex justify-end mb-2">
                        <p><strong>Folio:</strong> {{ $selectedFolio->folio }}</p>
                        <x-button class="bg-red-500 ml-4"
                        wire:click="clearSelection">x</x-button>
                    </div>
                    
                    <p class="px-3 py-3 whitespace-nowrap text-sm font-medium text-center 
                    @if ($selectedFolio->estado === 'COMPLETO') bg-green-400
                    @elseif ($selectedFolio->estado === 'PARCIAL') bg-yellow-400 @endif
                    text-gray-900" ><strong>Estado del Movimiento:</strong> {{ $selectedFolio->estado }}</p> <br>
                    <table class="min-w-full w-full divide-y divide-gray-200">
                        <thead class="bg-gray-300">
                            <tr>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Número de inventario</th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Número de serie</th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Descripcion</th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Modelo</th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Marca</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($selectedFolio->bien as $bien)
                                <tr class="hover:bg-gray-100" wire:key="{{ $bien->id }}">
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $bien->numero_inventario }}</td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $bien->numero_serie }}</td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $bien->descripcion }}</td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $bien->modelo }}</td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $bien->marca }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mb-4">
                    <label for="observacion" class="block mb-2 text-sm font-medium text-gray-900">Observaciones</label>
                    <input type="text" wire:model="observacion" id="observacion"
                        class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error('observacion')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="fecha" class="block mb-2 text-sm font-medium text-gray-900">Fecha de
                        Cancelación</label>
                    <input type="date" wire:model="fecha" id="fecha"
                        class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
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
            <x-danger-button wire:click="cancelResguardo" class="ml-2" wire:loading.attr="disabled">
                Cancelar
            </x-danger-button>

        </x-slot>
    </x-dialog-modal>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
</div>
