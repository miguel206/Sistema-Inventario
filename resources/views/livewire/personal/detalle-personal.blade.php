<div>
    <div>
        <h2 class="px-6 pt-2 pb-4">Detalles del Personal</h2>
        <div class="px-6 flex justify-between">
            <p class="text-left text-xl font-medium text-gray-700 tracking-wider">Nombre:
                <strong>{{ $personal->nombre }}</strong>
            </p>
            <p class="text-left text-xl font-medium text-gray-700 tracking-wider mr-8">Area:
                <strong>{{ $personal->area }}</strong>
            </p>
        </div>
        <!-- Aquí puedes mostrar más detalles del personal según tus necesidades -->
        <div class="py-4">
            <div class="flex">
                <h3 class="px-6 py-3 text-left text-xl font-medium text-gray-500 tracking-wider">Historial de
                    movimientos:
                </h3>
                <x-button wire:click="openModalhistorial({{ $personal->id }})" class="bg-amber-500 px-2"><svg
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd"
                            d="M15.988 3.012A2.25 2.25 0 0 1 18 5.25v6.5A2.25 2.25 0 0 1 15.75 14H13.5V7A2.5 2.5 0 0 0 11 4.5H8.128a2.252 2.252 0 0 1 1.884-1.488A2.25 2.25 0 0 1 12.25 1h1.5a2.25 2.25 0 0 1 2.238 2.012ZM11.5 3.25a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 .75.75v.25h-3v-.25Z"
                            clip-rule="evenodd" />
                        <path fill-rule="evenodd"
                            d="M2 7a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7Zm2 3.25a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Zm0 3.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Z"
                            clip-rule="evenodd" />
                    </svg>
                </x-button>
            </div>
            
            <div class="bg-gray-300 mt-4">
                <div class="py-2 ">
                    <h2 class=" text-center text-xl font-semibold mb-2">Prestamos activos:</h2>
                </div>
                <table class="min-w-full bg-gray-100">
                    <thead class="bg-gray-200">
                        <tr class="text-center">
                            {{-- <th scope="col"
                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Folio</th> --}}
                            <th scope="col" class="px-3 py-3">
                                Descripción</th>
                            <th scope="col" class="px-3 py-3">Marca
                            </th>
                            <th scope="col" class="px-3 py-3">
                                Modelo</th>
                            <th scope="col" class="px-3 py-3">
                                Número de Serie</th>
                            <th scope="col" class="px-3 py-3">
                                Número
                                de Inventario</th>
                            <th scope="col" class="px-3 py-3">
                                Observacion</th>
                            <th scope="col" class="px-3 py-3">
                                Estado</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($personal->bienes as $bien)
                            <tr class="text-center">
                                {{-- <td class="px-3 py-4 whitespace-nowrap">{{ $bien->folio }}</td> --}}
                                <td class="border px-4 py-2">{{ $bien->descripcion }}</td>
                                <td class="border px-4 py-2">{{ $bien->marca }}</td>
                                <td class="border px-4 py-2">{{ $bien->modelo }}</td>


                                <td class="border px-4 py-2">
                                    @if ($bien->numero_serie)
                                        <a href="{{ route('bienes.detalle', ['id' => $bien->id]) }}">
                                            <strong>
                                                <P class="text-gray-900 hover:text-blue-500 hover:underline">
                                                    {{ $bien->numero_serie }} </P>
                                            </strong>
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="border px-4 py-2">
                                    @if ($bien->numero_inventario)
                                        <a href="{{ route('bienes.detalle', ['id' => $bien->id]) }}">
                                            <strong>
                                                <P class="text-gray-900 hover:text-blue-500 hover:underline">
                                                    {{ $bien->numero_inventario }} </P>
                                            </strong>
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="border px-4 py-2 whitespace-nowrap">

                                    @if ($bien->observacion)
                                        {{ $bien->observacion }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="border px-4 py-2  @if ($bien->estado === 'RESGUARDO' && 'CANCELADO') bg-red-400 @endif">
                                    {{ $bien->estado }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <x-dialog-modal wire:model="showModalhistorial" maxWidth="6xl">
                <x-slot name="title">
                    historial de movimientos
                </x-slot>

                <x-slot name="content">
                    <div class="overflow-auto max-h-[500px]">

                        @if ($personalNombre && $personalArea)
                            <div class="flex justify-between mb-8">
                                <h2 class="text-xl font-bold">{{ $personalNombre }}</h2>
                                <h2 class="pr-4 text-xl font-bold">{{ $personalArea }}</h2>
                            </div>
                            <hr>
                        @endif

                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Folio</th>
                                    <th class="px-4 py-2">Tipo de Movimiento</th>

                                    <th class="px-4 py-2">Fecha</th>
                                    <th class="px-4 py-2">Observaciones</th>
                                    <th class="px-4 py-2">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($movimientos as $movimiento)
                                    <tr>
                                        {{-- <td class="border px-4 py-2">{{ $movimiento->folio }}</td> --}}
                                        <td class="border px-4 py-2">
                                            @if ($movimiento->tipo_moviento === 'RESGUARDO')
                                                <a href="{{ route('detallesFolios', ['id' => $movimiento->id]) }}">
                                                    <p class="underline"><strong>{{ $movimiento->folio }}</strong></p>
                                                </a>
                                            @else
                                                {{ $movimiento->folio }}
                                            @endif

                                        </td>
                                        <td class="border px-4 py-2">{{ $movimiento->tipo_moviento }}</td>

                                        <td class="border px-4 py-2">{{ $movimiento->fecha }}</td>
                                        <td class="border px-4 py-2">
                                            @if ($movimiento->observaciones)
                                                {{ $movimiento->observaciones }}
                                            @else
                                                Sin observaciones
                                            @endif
                                        </td>
                                        <td
                                            class="border px-4 py-2 @if ($movimiento->estado === 'COMPLETO') bg-green-400
                                                @elseif ($movimiento->estado === 'TERMINADO' && 'CANCELADO') bg-red-400
                                                @elseif ($movimiento->estado === 'BAJA') bg-gray-400
                                                @elseif ($movimiento->estado === 'PARCIAL') bg-yellow-400 @endif">
                                            <span class="text-black">{{ $movimiento->estado }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($movimientos instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="my-2 mx-2">
                            {{ $movimientos->links() }}
                        </div>
                    @endif


                </x-slot>

                <x-slot name="footer">
                    <x-button wire:click="closeModalhistorial">
                        Cancelar
                    </x-button>

                </x-slot>
            </x-dialog-modal>
        </div>
    </div>

</div>
