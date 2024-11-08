<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full sm:px-6 lg:px-8 bg-gray-50">
                <div class="p-6">
                    <h2 class="text-xl"><strong>Folio: </strong>{{ $movimiento->folio }}</h2>


                    <div class="grid grid-cols-1 sm:grid-cols-2 text-xl">
                        <p><strong>Tipo de Movimiento:</strong>
                            {{-- {{ $movimiento->tipo_moviento }} --}}
                            @if ($movimiento->tipo_moviento == 'RESGUARDO')
                                Préstamo
                            @endif
                        </p>
                        <p><strong>Estado:</strong>
                            {{-- {{ $movimiento->estado }} --}}
                            <span
                                class="px-4 py-1 rounded-full text-white 
                                @if ($movimiento->estado == 'COMPLETO') bg-green-500
                                @elseif ($movimiento->estado == 'PARCIAL') bg-yellow-500
                                @elseif ($movimiento->estado == 'TERMINADO' || $movimiento->estado == 'CANCELADO') bg-red-500
                                @elseif ($movimiento->estado == 'N/A') bg-gray-500 @endif">
                                {{ $movimiento->estado }}
                            </span>
                        </p>

                        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($movimiento->fecha)->format('d-m-Y') }}</p>
                        <br><br>
                        <p><strong>Solicitante:</strong> {{ $movimiento->personal->nombre }}</p>
                        <p><strong>Adscripción:</strong> {{ $movimiento->personal->area }}</p>
                        <p><strong>Cantidad de bienes prestados:</strong> {{ intval($movimiento->cantidad) }}</p>

                    </div>
                    <br>
                    <p class="text-xl"><strong>Observaciones:</strong>
                        @if ($movimiento->observaciones)
                            {{ $movimiento->observaciones }}
                        @else
                            Sin Observaciones
                        @endif

                    </p>
                    <!-- Aquí puedes mostrar más detalles del movimiento según tus necesidades -->
                </div>
                <div class="m-4">
                    <div class="overflow-hidden rounded-lg shadow-md bg-gray-100">
                        <div class="">
                            <div class="py-2 bg-green-400">
                                <h2 class=" text-center text-lg font-semibold mb-2">Bienes en Resguardo</h2>
                            </div>

                            @if ($movimiento->bien->isEmpty())
                                <p class="text-center my-4">Se han devuelto todos los bienes del resguardo</p>
                            @else
                                <table class="min-w-full w-full divide-y divide-gray-100">
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
                                                Fecha de resguardo
                                            </th>
                                            {{-- <th scope="col"
                                                class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                
                                            </th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($movimiento->bien as $bien)
                                            <tr class="hover:bg-gray-100" wire:key="{{ $bien->id }}">

                                                <td
                                                    class="px-3 py-3 text-center  whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $bien->descripcion }}
                                                </td>
                                                <td
                                                    class="px-3 py-3 text-center  whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $bien->modelo }}
                                                </td>
                                                <td
                                                    class="px-3 py-3 text-center  whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $bien->marca }}
                                                </td>
                                                <td
                                                    class="px-3 py-3 text-center  whitespace-nowrap text-sm font-medium text-gray-900">

                                                    @if ($bien->numero_inventario)
                                                        <a href="{{ route('bienes.detalle', ['id' => $bien->id]) }}">
                                                            <strong>
                                                                <p
                                                                    class="text-gray-900 hover:text-blue-500 hover:underline">
                                                                    {{ $bien->numero_inventario }}</p>
                                                            </strong>
                                                        </a>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-3 py-3 text-center  whitespace-nowrap text-sm font-medium text-gray-900">

                                                    @if ($bien->numero_serie)
                                                        <a href="{{ route('bienes.detalle', ['id' => $bien->id]) }}">
                                                            <strong>
                                                                <p
                                                                    class="text-gray-900 hover:text-blue-500 hover:underline">
                                                                    {{ $bien->numero_serie }}</p>
                                                            </strong>
                                                        </a>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-3 py-3 text-center  whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ \Carbon\Carbon::parse($movimiento->fecha)->format('d-m-Y') }}
                                                </td>
                                                {{-- <td class="border px-4 py-2">
                                                    <a href="{{ route('bienes.detalle', ['id' => $bien->id]) }}">
                                                        <x-button class="bg-green-500 px-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 20 20" fill="currentColor"
                                                                class="w-5 h-5">
                                                                <path fill-rule="evenodd"
                                                                    d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </x-button>
                                                    </a>
                                                </td> --}}
                                            </tr>
                                            <!-- Mostrar más detalles del bien según tus necesidades -->
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif

                        </div>
                    </div>

                    @if ($movimiento->estado === 'PARCIAL' || $movimiento->estado === 'TERMINADO' || $movimiento->estado === 'CANCELADO')
                        <!-- Detalles de los bienes devueltos -->
                        <div class="overflow-hidden rounded-lg shadow-md bg-gray-100 mt-8">
                            <div class="">
                                <div class="py-2 bg-red-400">
                                    <h2 class="text-lg text-center font-semibold mb-2">Bienes del Resguardo Devueltos
                                    </h2>
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
                                                Fecha de devolución
                                            </th>
                                            {{-- <th scope="col"
                                                class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                
                                            </th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($movimiento->bienDevueltos as $bien)
                                            <tr class="hover:bg-gray-100" wire:key="{{ $bien->id }}">

                                                <td
                                                    class="px-3 py-3 text-center  whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $bien->descripcion }}</td>
                                                <td
                                                    class="px-3 py-3 whitespace-nowrap text-center  text-sm font-medium text-gray-900">
                                                    {{ $bien->modelo }}</td>
                                                <td
                                                    class="px-3 py-3 whitespace-nowrap text-center  text-sm font-medium text-gray-900">
                                                    {{ $bien->marca }}</td>
                                                <td
                                                    class="px-3 py-3 whitespace-nowrap text-center  text-sm font-medium text-gray-900">

                                                    @if ($bien->numero_inventario)
                                                        <a href="{{ route('bienes.detalle', ['id' => $bien->id]) }}">
                                                            <strong>
                                                                <p
                                                                    class="text-gray-900 hover:text-blue-500 hover:underline">
                                                                    {{ $bien->numero_inventario }}</p>
                                                            </strong>
                                                        </a>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-3 py-3 whitespace-nowrap text-sm text-center  font-medium text-gray-900">

                                                    @if ($bien->numero_serie)
                                                        <a href="{{ route('bienes.detalle', ['id' => $bien->id]) }}">
                                                            <strong>
                                                                <p
                                                                    class="text-gray-900 hover:text-blue-500 hover:underline">
                                                                    {{ $bien->numero_serie }}</p>
                                                            </strong>
                                                        </a>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-3 py-3 whitespace-nowrap text-center  text-sm font-medium text-gray-900">
                                                    {{ \Carbon\Carbon::parse($bien->pivot->deleted_at)->format('d-m-Y') }}
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- Agregar el paginador -->
                {{-- <div class="my-2 mx-2">
                    {{ $movimientosListas->links() }}
                </div> --}}
            </div>

        </div>
    </div>
</div>
