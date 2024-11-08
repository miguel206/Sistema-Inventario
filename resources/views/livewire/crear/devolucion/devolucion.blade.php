<div wire:ignore.self>
    <div>
        <x-button class="bg-pink-600 py-3" wire:click="$set('open',true)">
            {{-- <svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path
                    d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
            </svg> --}}
            devolucion
        </x-button>
    </div>

    {{-- <form wire:submit.prevent="submit"> --}}
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            GENERAR UNA DEVOLUCION
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
                        {{-- <x-input class="mb-3" wire:model.live="terminoBusquedaBienes" type="text"
                            placeholder="Buscar bienes..." /> --}}
                        @if ($selected_personal)
                        
                            <div class="mt-4">
                                <p class="mb-2">Bienes en resguardo <strong>{{ $selected_personal->nombre }}</strong> </p>
                                <ul>
                                    @foreach ($bienes_asociados as $bien)

                                        <li>
                                            <x-input type="checkbox" wire:model="selected_bienes"
                                                value="{{ $bien->id }}" class="mr-2" />
                                            {{ $bien->descripcion }} - {{ $bien->numero_inventario }} -
                                            {{ $bien->numero_serie }} - {{ $bien->marca }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <p class="mb-4 mt-4">Búsqueda de bienes</p>
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
                                class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
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
                                    <strong>{{ $p->nombre }} - {{ $p->area }}</strong>
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
            <x-danger-button wire:click="devolverBienes" class="ml-2" wire:loading.attr="disabled">
                guardar
            </x-danger-button>

        </x-slot>
    </x-dialog-modal>

    {{-- </form> --}}
</div>
