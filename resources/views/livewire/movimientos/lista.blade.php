<div>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full sm:px-6 lg:px-8 bg-gray-200">
                <div class="overflow-hidden rounded-lg shadow-md bg-gray-200 ">
                    <h1 class="px-6 pt-3 text-center text-lg font-bold text-gray-800 uppercase tracking-wider">
                        LISTA DE movimientos</h1>

                    <table class="min-w-full w-full divide-y divide-gray-200">
                        <thead class=" bg-gray-300">
                            <tr>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                                    Número de folio
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                                    Tipo de movimiento
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                                    Solicitante
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                                    Observaciones
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">

                                </th>

                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($movimientos as $movimiento)
                                <tr>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $movimiento->folio }}
                                        {{-- <a href="{{ route('personal.detalle', ['id' => $movimiento->id]) }}">{{ $movimiento->folio }}</a> --}}
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $movimiento->tipo_moviento }}
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $movimiento->fecha }}
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{-- {{ $movimiento->personal->nombre }} --}}
                                        @if ($movimiento->personal)
                                            {{-- {{ $movimiento->personal->nombre ?? 'Sin asignar' }} --}}
                                            {{-- {{ $movimiento->personal->nombre }} --}}
                                            <a
                                                href="{{ route('personal.detalle', ['id' => $movimiento->personal->id]) }}">{{ $movimiento->personal->nombre }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td
                                        class="px-3 py-3 whitespace-pre-line text-sm font-medium text-gray-900 max-w-sm overflow-y-auto">
                                        {{ $movimiento->observaciones }}
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div>

                                            <x-button class="bg-green-500 px-1"><svg xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z"
                                                        clip-rule="evenodd" />
                                                </svg>

                                            </x-button>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>




                </div>
                <!-- Agregar el paginador -->
                {{-- <div class="my-2 mx-2">
                    {{ $movimientosListas->links() }}
                </div> --}}
            </div>

        </div>
    </div>
</div>
