

<div>
    <div>
        <x-button class="bg-green-500" wire:click="$set('open',true)"><svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path
                    d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
            </svg>
        </x-button>
    </div>

    <form wire:submit.prevent="submit">
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                GENERAR UN RESGUARDO
            </x-slot>

            <x-slot name="content">
                <div class="mt-2">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">seleccion
                        personal</label>
                    <div class="mt-3">
                        <select wire:model="selected_personal"
                            class="bg-gray-50 border-gray-300 text-gray-900 text-sm rounded-lg select2 p-2 w-full focus:ring-blue-500 focus:border-blue-500">
                            <option value="" selected>Escoje un nombre</option>
                            @foreach ($lista_personal as $persona)
                                <option value="{{ $persona->id }}">{{ $persona->nombre }} - {{ $persona->area }}
                                </option>
                            @endforeach
                        </select>
                        @error('selected_personal')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="fecha" class="block my-2 text-sm font-medium text-gray-900">seleccion de
                            bienes</label>
                        <select class="select2multi" name="lista_bienes[]" multiple="multiple"
                            wire:model="selected_bienes">
                            @foreach ($lista_bienes as $bienes)
                                <option value="{{ $bienes->id }}">{{ $bienes->numero_serie }} -
                                    {{ $bienes->numero_inventario }} - {{ $bienes->descripcion }} -
                                    {{ $bienes->modelo }}
                                </option>
                            @endforeach
                        </select>
                        @error('selected_bienes')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-3">
                        <label for="observacion" class="block my-2 text-sm font-medium text-gray-900">Observación
                            (opcional)</label>
                        <input type="text" wire:model="observacion" id="observacion"
                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
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

            </x-slot>

            <x-slot name="footer">
                <x-button wire:click="$set('open',false)" wire:loading.attr="disabled">
                    Cerrar
                </x-button>

                <x-danger-button type="submit" class="ml-2" wire:loading.attr="disabled">
                    guardar
                </x-danger-button>

            </x-slot>
        </x-dialog-modal>
        
    </form>
</div>
