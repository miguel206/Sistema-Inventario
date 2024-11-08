<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    {{-- @livewire('crearbienes') --}}
    {{-- @livewire('crear.bienes-dinamico') --}}
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full sm:px-6 lg:px-8 bg-gray-200">
                <div class="overflow-hidden rounded-lg shadow-md bg-gray-200 ">
                    <h1 class="px-6 pt-3 text-center text-lg font-bold text-gray-800 uppercase tracking-wider">
                        LISTA DE BIENES</h1>
                    <div class="mr-4 mb-2 flex justify-end">
                        <input type="text" wire:model.live="search" placeholder="Buscar..."
                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-64 p-2 rounded-md">
                    </div>
                    <table class="min-w-full w-full divide-y divide-gray-200">
                        <thead class="bg-gray-300">
                            <tr>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Número de inventario
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Número de serie
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Descripcion
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Modelo
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Marca
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    observacion
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Fecha de baja
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    PDF
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($registrosEliminados as $bien)
                                <tr class="hover:bg-gray-100" wire:key="{{ $bien->id }}">
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        @if ($bien->numero_inventario)
                                            {{ $bien->numero_inventario }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">

                                        @if ($bien->numero_serie)
                                            <a
                                                href="{{ route('bienes.detalle', ['id' => $bien->id]) }}">{{ $bien->numero_serie }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $bien->descripcion }}
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $bien->modelo }}
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $bien->marca }}
                                    </td>
                                    <td
                                        class="px-3 py-3 whitespace-nowrap text-sm font-medium 
                                        @if ($bien->estado === 'DISPONIBLE') bg-green-400
                                        @elseif ($bien->estado === 'RESGUARDO') bg-red-400
                                        @elseif ($bien->estado === 'BAJA') bg-gray-400
                                        @elseif ($bien->estado === 'MANTENIMIENTO') bg-yellow-400 @endif
                                        text-gray-900">

                                        <a
                                            href="{{ route('bienes.detalle', ['id' => $bien->id]) }}">{{ $bien->estado }}</a>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $bien->observaciones }}
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($bien->fecha_baja)->format('d-m-Y') }}

                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">

                                        @if ($bien->documento)
                                            <a href="{{ Storage::url($bien->documento) }}" target="_blank">
                                                <x-button class="bg-yellow-500 px-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="size-5">
                                                        <path
                                                            d="M10.75 2.75a.75.75 0 0 0-1.5 0v8.614L6.295 8.235a.75.75 0 1 0-1.09 1.03l4.25 4.5a.75.75 0 0 0 1.09 0l4.25-4.5a.75.75 0 0 0-1.09-1.03l-2.955 3.129V2.75Z" />
                                                        <path
                                                            d="M3.5 12.75a.75.75 0 0 0-1.5 0v2.5A2.75 2.75 0 0 0 4.75 18h10.5A2.75 2.75 0 0 0 18 15.25v-2.5a.75.75 0 0 0-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5Z" />
                                                    </svg>
                                                </x-button>
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>




                </div>
                <!-- Agregar el paginador -->
                <!-- Agregar el paginador -->
                {{-- <div class="my-2 mx-2">
                    {{ $bienes->links() }}
                </div> --}}
            </div>
        </div>
    </div>

</div>
