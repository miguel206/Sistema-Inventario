<div>
    <div>
        <x-button class="bg-blue-600 py-3" wire:click="abrirModal">
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
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            Dar Bienes de Alta
        </x-slot>

        <x-slot name="content">
            <div class="container mx-auto my-auto p-8 bg-gray-100 max-h-[400px] overflow-y-auto">
                <div class="bg-pink-300 p-3 rounded-md mb-4">
                    <label for="fecha_ingreso" class="block mb-2 text-sm font-medium text-gray-900">Fecha de
                        Ingreso</label>
                    <input type="date" wire:model="fecha_ingreso" id="fecha_ingreso"
                        class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error('fecha_ingreso')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                @foreach ($workers as $index => $bien)
                    <div class="bg-white rounded-md shadow-md mb-4">

                        <div class="p-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900">Personal
                                #{{ $loop->iteration }}</label>

                            <div>
                            <label for="rfc_{{ $index }}" class="block mb-2 pt-3 text-sm font-medium text-gray-900">RFC (Opcional)</label>

                                <input type="text" wire:model.live="workers.{{ $index }}.rfc"
                                    id="rfc{{ $index }}"
                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @error('workers.' . $index . '.rfc')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>



                            <div>
                                <label for="nombre_{{ $index }}"
                                    class="block mb-2 pt-3 text-sm font-medium text-gray-900">Nombre completo</label>
                                <input type="text" wire:model.live="workers.{{ $index }}.nombre"
                                    id="nombre{{ $index }}"
                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @error('workers.' . $index . '.nombre')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="area_{{ $index }}"
                                    class="block mb-2 pt-3 text-sm font-medium text-gray-900">Área</label>
                                <select wire:model.live="workers.{{ $index }}.area"
                                    id="area{{ $index }}"
                                    class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="">Seleccione un área</option>
                                    <option value="Presidencia">Presidencia</option>
                                    <option value="Secretaria Ejecutiva">Secretaria Ejecutiva</option>
                                    <option value="Secretaría Administrativa">Secretaría Administrativa</option>
                                    <option value="Dirección Ejecutiva de Asociaciones Políticas">Dirección Ejecutiva de
                                        Asociaciones Políticas</option>
                                    <option value="Dirección Ejecutiva de Organización Electoral">Dirección Ejecutiva de
                                        Organización Electoral</option>
                                    <option value="Dirección Ejecutiva de Educación Cívica y Capacitación">Dirección
                                        Ejecutiva de Educación Cívica y Capacitación</option>
                                    <option value="Dirección Ejecutiva Jurídica y de lo Contencioso">Dirección Ejecutiva
                                        Jurídica y de lo Contencioso</option>
                                    <option value="Dirección Ejecutiva de Participación Ciudadana">Unidad Técnica de
                                        Planeación</option>
                                    <option value="Unidad Técnica del Servicio Profesional Electoral">Unidad Técnica del
                                        Servicio Profesional Electoral</option>
                                    <option value="Unidad de Transparencia">Unidad de Transparencia</option>
                                    <option value="Unidad Técnica de Comunicación Social">Unidad Técnica de Comunicación
                                        Social</option>
                                    <option value="Unidad Técnica de Oficialía Electoral">Unidad Técnica de Oficialía
                                        Electoral</option>
                                    <option value="Unidad Técnica de Servicios Informáticos">Unidad Técnica de Servicios
                                        Informáticos</option>
                                    <option value="Unidad Técnica de Género y No Discriminación">Unidad Técnica de
                                        Género y No Discriminación</option>
                                    <option value="Unidad Técnica de Asuntos Indígenas">Unidad Técnica de Asuntos
                                        Indígenas</option>
                                    <option value="Unidad Técnica de Vinculación con el INE">Unidad Técnica de
                                        Vinculación con el INE</option>
                                    <option value="otro">Otro...</option>
                                </select>
                                @error('workers.' . $index . '.area')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            @if ($workers[$index]['area'] === 'otro')
                                <div>
                                    <label for="nombre_{{ $index }}"
                                        class="block mb-2 pt-3 text-sm font-medium text-gray-900">Área
                                        específica</label>
                                    <input type="text" wire:model="workers.{{ $index }}.area_especifica"
                                        id="area_especifica{{ $index }}"
                                        class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    @error('workers.' . $index . '.area_especifica')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                        </div>



                        @if (count($workers) > 1)
                            <div class="flex justify-end items-center p-1 space-x-2">
                                <p class="text-red-700 font-semibold uppercase">Eliminar Personal
                                    #{{ $loop->iteration }}</p>
                                <x-button type="button" class="bg-red-500 text-white p-2 rounded"
                                    wire:click="removeBien({{ $index }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </x-button>
                            </div>
                        @endif


                    </div>
                @endforeach

                <div class="flex justify-start items-center p-1 space-x-2">
                    <x-button type="button" class=" bg-green-700" wire:click="addBien">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11.25a.75.75 0 0 0-1.5 0v2.5h-2.5a.75.75 0 0 0 0 1.5h2.5v2.5a.75.75 0 0 0 1.5 0v-2.5h2.5a.75.75 0 0 0 0-1.5h-2.5v-2.5Z"
                                clip-rule="evenodd" />
                        </svg>
                    </x-button>
                    <p class="text-green-700 font-semibold uppercase">Agregar otra persona</p>
                </div>


                {{-- <button type="submit">Guardar</button> --}}

            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$set('open',false)" wire:loading.attr="disabled">
                Cerrar
            </x-button>

            {{-- <x-danger-button type="submit" class="ml-2" wire:loading.attr="disabled"> --}}
            <x-danger-button type="submit" wire:click="$dispatch('confirm-presonal')" class="ml-2"
                wire:loading.attr="disabled">
                guardar
            </x-danger-button>

        </x-slot>
    </x-dialog-modal>
    {{-- </form> --}}

</div>
