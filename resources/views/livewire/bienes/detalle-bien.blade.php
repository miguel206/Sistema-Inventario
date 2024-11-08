<div>
    <div>
        <h2 class="px-6 pt-2 pb-4">Detalles del Bien</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 p-6">
            <div>
                <p class="text-left py-1 text-xl font-medium text-gray-700 uppercase tracking-wider">Numero de
                    inventario:
                    <strong>{{ $bien->numero_inventario }}</strong>
                </p>
            </div>

            <div>
                <p class="text-left py-1 text-xl font-medium text-gray-700 uppercase tracking-wider">Numero de serie:
                    <strong>{{ $bien->numero_serie }}</strong>
                </p>
            </div>

            <div>
                <p class="text-left py-1 text-xl font-medium text-gray-700 uppercase tracking-wider">Descripcion:
                    <strong>{{ $bien->descripcion }}</strong>
                </p>
            </div>

            <div>
                <p class="text-left py-1 text-xl font-medium text-gray-700 uppercase tracking-wider">Modelo:
                    <strong>{{ $bien->modelo }}</strong>
                </p>
            </div>

            <div>
                <p class="text-left py-1 text-xl font-medium text-gray-700 uppercase tracking-wider">Marca:
                    <strong>{{ $bien->marca }}</strong>
                </p>
            </div>

            <div>
                <p class="text-left py-1 text-xl font-medium text-gray-700 uppercase tracking-wider">Precio:
                    <strong>{{ $bien->precio }}</strong>
                </p>
            </div>

            <div>
                <p class="text-left py-1 text-xl font-medium text-gray-700 uppercase tracking-wider">Factura:
                    <strong>{{ $bien->factura }}</strong>
                </p>
            </div>

            <div>
                <p class="text-left py-1 text-xl font-medium text-gray-700 uppercase tracking-wider">Observaciones:

                    @if ($bien->observaciones)
                        <strong>{{ $bien->observaciones }}</strong>
                    @else
                        N/A
                    @endif
                </p>
            </div>

            <div>
                <p class="text-left py-1 text-xl font-medium text-gray-700 uppercase tracking-wider">Estado:
                    <strong>{{ $bien->estado }}</strong>
                </p>
            </div>

        </div>

        <div class="flex items-center">
            <h3 class="px-6 py-3 text-left text-xl font-medium text-gray-500 uppercase tracking-wider">Historial
                de movimientos:</h3>
            <x-button wire:click="openModalhistorial({{ $bien->id }})" class="ml-2 bg-amber-500 px-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M15.988 3.012A2.25 2.25 0 0 1 18 5.25v6.5A2.25 2.25 0 0 1 15.75 14H13.5V7A2.5 2.5 0 0 0 11 4.5H8.128a2.252 2.252 0 0 1 1.884-1.488A2.25 2.25 0 0 1 12.25 1h1.5a2.25 2.25 0 0 1 2.238 2.012ZM11.5 3.25a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 .75.75v.25h-3v-.25Z"
                        clip-rule="evenodd" />
                    <path fill-rule="evenodd"
                        d="M2 7a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7Zm2 3.25a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Z"
                        clip-rule="evenodd" />
                </svg>
            </x-button>
        </div>
        <!-- Aquí puedes mostrar más detalles del personal según tus necesidades -->
        @if ($bien->estado == 'RESGUARDO')
            <div class="py-2 px-4 my-2  rounded-md">
                <div class="py-4 px-4 ">

                    <div class="px-6 py-3 text-left bg-orange-200 rounded-md">
                        <h3 class=" font-medium tracking-wider">Bien en resguardo de:</h3>
                        <p class="text-left py-1 text-xl font-medium text-gray-700 uppercase tracking-wider">RFC:
                            <strong>{{ $bien->personal->rfc }}</strong>
                        </p>
                        <p class="text-left py-1 text-xl font-medium text-gray-700 uppercase tracking-wider">Nombre:
                            <strong>{{ $bien->personal->nombre }}</strong>
                        </p>
                        <p class="text-left py-1 text-xl font-medium text-gray-700 uppercase tracking-wider">Área:
                            <strong>{{ $bien->personal->area }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="py-4 px-4 text-xl text-gray-500">Sin resguardo activo</div>
        @endif

        <x-dialog-modal wire:model="showModalhistorial" maxWidth="6xl">
            <x-slot name="title">
                Historial de Resguardos
            </x-slot>

            <x-slot name="content">
                <div class="overflow-auto max-h-[500px]">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Folio</th>
                                <th class="px-4 py-2">Tipo de Movimiento</th>
                                <th class="px-4 py-2">Solicitante</th>
                                <th class="px-4 py-2">Adscripción</th>
                                <th class="px-4 py-2">Observaciones</th>
                                <th class="px-4 py-2">Fecha</th>
                                <th class="px-4 py-2">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($movimientos as $movimiento)
                                <tr>
                                    <td class="border px-4 py-2">{{ $movimiento->folio }}</td>
                                    <td class="border px-4 py-2">{{ $movimiento->tipo_moviento }}</td>
                                    <td class="border px-4 py-2 uppercase">
                                        @if ($movimiento->personal)
                                            {{ $movimiento->personal->nombre }}
                                        @else
                                            sin solicitante
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2 uppercase">
                                        @if ($movimiento->personal)
                                            {{ $movimiento->personal->area }}
                                        @else
                                            sin area
                                        @endif
                                    </td>

                                    <td class="border px-4 py-2">
                                        @if ($movimiento->observaciones)
                                            {{ $movimiento->observaciones }}
                                        @else
                                            Sin observaciones
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">{{ $movimiento->fecha }}</td>
                                    <td
                                        class="border px-4 py-2 @if ($movimiento->estado === 'COMPLETO') bg-green-400
                                            @elseif ($movimiento->estado === 'TERMINADO' && 'CANCELADO') bg-red-400
                                            @elseif ($movimiento->estado === 'BAJA') bg-gray-400
                                            @elseif ($movimiento->estado === 'PARCIAL') bg-yellow-400 @endif">
                                        {{-- <span class="text-black">{{ $movimiento->estado }}</span> --}}
                                        @if ($movimiento->tipo_moviento == 'DEVOLUCION')
                                            <span class="uppercase">devuelto</span>
                                        @elseif ($movimiento->tipo_moviento == 'ALTA')
                                            <span class="uppercase">dado de alta</span>
                                        @elseif ($movimiento->tipo_moviento)
                                            <span class="text-success">{{ $movimiento->estado }}</span>
                                        @endif
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
