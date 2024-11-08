<div wire:ignore.self>
    <div>
        <x-button class="bg-pink-600 py-3" wire:click="$set('open',true)">
            agregar resguardo
        </x-button>
    </div>

    {{-- <form wire:submit.prevent="submit"> --}}
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            GENERAR UN RESGUARDO
        </x-slot>

        <x-slot name="content">
            <div>
                <x-input class="mb-3" wire:model.live="terminoBusquedaPersonals" type="text"
                    placeholder="Buscar personal..." />

                @if ($selected_personal)
                    <div class="flex justify-end font-bold text-lg ml-4">
                        {{ $selected_personal->nombre }} - {{ $selected_personal->area }}
                        <x-button class="bg-red-500 ml-4" wire:click="clearSelection">Eliminar</x-button>
                    </div>
                    {{-- seleccion de bienes a resguardar --}}
                    <div>
                        <x-input class="mb-3" wire:model.live="terminoBusquedaBienes" type="text"
                            placeholder="Buscar bienes..." />
                        @if ($terminoBusquedaBienes)
                            <ul>
                                @foreach ($bienes as $b)
                                    <li>
                                        {{-- Verificar si el bien ya está seleccionado --}}
                                        @if (!in_array($b->id, $selected_bienes))
                                            <x-input type="checkbox" wire:click="selectBien({{ $b->id }})"
                                                class="mr-2" />
                                        @else
                                            <x-input type="checkbox" disabled class="mr-2" />
                                        @endif
                                        {{ $b->descripcion }} - {{ $b->numero_inventario }} - {{ $b->numero_serie }} -
                                        {{ $b->marca }}
                                        <!-- Mostrar la descripción del bien, ajusta según necesites -->
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="mb-4 mt-4">Búsqueda de bienes</p>
                        @endif

                        @if (count($selected_bienes) > 0)
                            <ul>
                                @foreach ($selected_bienes as $index => $bienId)
                                    @php
                                        // Obtener el bien correspondiente al ID
                                        $bien = App\Models\Bien::find($bienId);
                                    @endphp
                                    @if ($bien)
                                        {{-- <div class="flex justify-end font-bold text-lg ml-4 my-2"> --}}
                                        <div>

                                            {{-- <li>
                                                    {{ $bien->descripcion }} - {{ $bien->numero_inventario }} -
                                                    {{ $bien->numero_serie }} - {{ $bien->marca }}
                                                    <x-button class="bg-red-500 ml-4"
                                                        wire:click="removeBien({{ $index }})">Eliminar</x-button>
                                                </li> --}}
                                            <table class="my-4">
                                                <thead>
                                                    <tr>
                                                        <th class="px-2">Descripcion</th>
                                                        <th class="px-2">Número de Inventario</th>
                                                        <th class="px-2">Número de Serie</th>
                                                        <th class="px-2">Marca</th>
                                                        <th class="px-2"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="px-2">{{ $bien->descripcion }}</td>
                                                        <td class="px-2">{{ $bien->numero_inventario }}</td>
                                                        <td class="px-2">{{ $bien->numero_serie }}</td>
                                                        <td class="px-2">{{ $bien->marca }}</td>
                                                        <td>
                                                            <x-button class="bg-red-500 ml-4"
                                                                wire:click="removeBien({{ $index }})">Eliminar</x-button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    @endif
                                @endforeach
                            </ul>
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
                            <label for="fecha" class="block my-2 text-sm font-medium text-gray-900" >Fecha</label>
                            <input type="date" wire:model="fecha" id="fecha"
                                class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" min="{{ $fecha_minima }}">
                        </div>
                        @error('fecha')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                @else
                    @if ($terminoBusquedaPersonals)
                        <ul>
                            @foreach ($personal as $p)
                                <li>
                                    <x-input type="checkbox" wire:model="selected_personal_id"
                                        value="{{ $p->id }}" wire:change="selectPersonal({{ $p->id }})"
                                        class="mr-2" />
                                    {{ $p->nombre }} - {{ $p->area }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="mb-8">Busqueda de personal</p>
                    @endif
                @endif

                <!-- Buscar y seleccionar bienes -->


            </div>


        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$set('open',false)" wire:loading.attr="disabled">
                Cerrar
            </x-button>

            {{-- <x-danger-button type="submit" class="ml-2" wire:loading.attr="disabled"> --}}
            <x-danger-button wire:click="submit" class="ml-2" wire:loading.attr="disabled">
                guardar
            </x-danger-button>

        </x-slot>
    </x-dialog-modal>

    {{-- </form> --}}
</div>
