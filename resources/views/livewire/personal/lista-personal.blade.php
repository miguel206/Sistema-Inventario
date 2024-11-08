<div>
    {{-- In work, do what you enjoy. --}}
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full sm:px-6 lg:px-8 bg-gray-200">
                <div class="overflow-hidden rounded-lg shadow-md bg-gray-200 ">
                    <h1
                        class="px-6 bg-gray-200 pt-3 text-center text-lg font-bold text-gray-800 uppercase tracking-wider">
                        LISTA DE PERSONAl</h1>

                    {{-- <div>
                        @livewire('personal.crear-dinamico')

                    </div> --}}
                    {{-- <div class="mx-2">
                        @livewire('personal.crear-dinamico-interno')
                    </div> --}}
                    <div class="mr-4 mb-2 flex justify-end">
                        <div class="flex justify-between">
                            <div class="flex items-center">
                                <input type="text" wire:model.live="search" placeholder="Buscar..."
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-64 p-2 rounded-md mr-4">
                                <select class="pl-2 pr-8 rounded-md py-2 mr-4" wire:model.live="paginateDinamico">
                                    <option value="10">10</option>
                                    <option value="5">5</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <table class="min-w-full w-full divide-y divide-gray-200">
                        <thead class="bg-gray-300">
                            <tr>
                                {{-- <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    RFC
                                </th> --}}
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    NOMBRE
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    AREA
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">

                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($listaPersonal as $personal)
                                <tr class="hover:bg-gray-100" wire:key="{{ $personal->id }}">
                                    {{-- <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $personal->rfc }}
                                    </td> --}}
                                    {{-- <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $personal->nombre }}
                                    </td> --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <a href="{{ route('personal.detalle', ['id' => $personal->id]) }}"
                                            class="text-gray-900 hover:text-blue-500 hover:underline">
                                            {{ $personal->nombre }}
                                        </a>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $personal->area }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div>
                                            @hasanyrole('admin|supervisor')
                                                <x-button class="bg-sky-700 px-1"
                                                    wire:click="openEdicionPersonal({{ $personal->id }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-5 h-5">
                                                        <path
                                                            d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                                        <path
                                                            d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                                    </svg>
                                                </x-button>

                                                <x-button wire:click="openBajaPersonal({{ $personal->id }})"
                                                    class="bg-red-500 px-1"><svg xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                                        <path fill-rule="evenodd"
                                                            d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                                            clip-rule="evenodd" />
                                                    </svg>

                                                </x-button>
                                            @endhasanyrole
                                            <x-button wire:click="openModalhistorial({{ $personal->id }})"
                                                class="bg-slate-600 px-1"><svg xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                                    <path fill-rule="evenodd"
                                                        d="M15.988 3.012A2.25 2.25 0 0 1 18 5.25v6.5A2.25 2.25 0 0 1 15.75 14H13.5V7A2.5 2.5 0 0 0 11 4.5H8.128a2.252 2.252 0 0 1 1.884-1.488A2.25 2.25 0 0 1 12.25 1h1.5a2.25 2.25 0 0 1 2.238 2.012ZM11.5 3.25a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 .75.75v.25h-3v-.25Z"
                                                        clip-rule="evenodd" />
                                                    <path fill-rule="evenodd"
                                                        d="M2 7a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7Zm2 3.25a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Zm0 3.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </x-button>

                                            <x-button wire:click="obtenerHistorialBienes({{ $personal->id }})"
                                                class="bg-slate-600 px-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="size-5">
                                                    <path
                                                        d="M10.75 16.82A7.462 7.462 0 0 1 15 15.5c.71 0 1.396.098 2.046.282A.75.75 0 0 0 18 15.06v-11a.75.75 0 0 0-.546-.721A9.006 9.006 0 0 0 15 3a8.963 8.963 0 0 0-4.25 1.065V16.82ZM9.25 4.065A8.963 8.963 0 0 0 5 3c-.85 0-1.673.118-2.454.339A.75.75 0 0 0 2 4.06v11a.75.75 0 0 0 .954.721A7.506 7.506 0 0 1 5 15.5c1.579 0 3.042.487 4.25 1.32V4.065Z" />
                                                </svg>

                                            </x-button>



                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Modal de edicion-->
                    <x-dialog-modal wire:model="openEdicion" maxWidth="4xl">
                        <x-slot name="title">
                            Edicion de personal
                        </x-slot>

                        <x-slot name="content">
                            <div class="overflow-auto max-h-[500px]">
                                @if ($workers)
                                    <div>
                                        <label for="rfc"
                                            class="block mb-2 pt-3 text-sm font-medium text-gray-900">RFC con
                                            homoclave</label>
                                        <input type="text" wire:model.live="workers.rfc" id="rfc"
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        @error('workers.rfc')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror

                                        <label for="nombre"
                                            class="block mb-2 pt-3 text-sm font-medium text-gray-900">Nombre
                                            completo</label>
                                        <input type="text" wire:model.live="workers.nombre" id="nombre"
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        @error('workers.nombre')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror

                                        <label for="area"
                                            class="block mb-2 pt-3 text-sm font-medium text-gray-900">Área</label>
                                        <input type="text" wire:model.live="workers.area" id="area"
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        @error('workers.area')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif

                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <x-button wire:click="$set('openEdicion',false)">
                                Cerrar
                            </x-button>

                            <x-danger-button type="button" class="ml-2" wire:click="updatePersonal"
                                wire:loading.attr="disabled">
                                Actualizar
                            </x-danger-button>
                        </x-slot>

                    </x-dialog-modal>

                    <!-- Modal de estado-->
                    <x-dialog-modal wire:model="showModalhistorial" maxWidth="4xl">
                        <x-slot name="title">
                            Historial de Movimientos del personal
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
                                                        <a
                                                            href="{{ route('detallesFolios', ['id' => $movimiento->id]) }}">
                                                            <p
                                                                class="text-gray-900 hover:text-blue-500 hover:underline"">
                                                                <strong>{{ $movimiento->folio }}</strong>
                                                            </p>
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
                                                    {{-- <span class="text-black">{{ $movimiento->estado }}</span> --}}
                                                    @if ($movimiento->tipo_moviento == 'DEVOLUCION')
                                                        <span class="uppercase">devuelto</span>
                                                    @elseif ($movimiento->tipo_moviento == 'ALTA')
                                                        <span class="uppercase">dado de alta</span>
                                                    @elseif ($movimiento->tipo_moviento == 'REGISTRO')
                                                        <span class="uppercase">Registrado en el sistema</span>
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
                                Cerrar
                            </x-button>
                        </x-slot>
                    </x-dialog-modal>

                    <!-- Modal de estado-->
                    <x-dialog-modal wire:model="openBaja" maxWidth="4xl">
                        <x-slot name="title">
                            Dar personal de baja
                        </x-slot>

                        <x-slot name="content">
                            <div class="overflow-auto max-h-[500px]">
                                @if ($selectedWorker)
                                    <div class="mb-4">
                                        <label for="rfc"
                                            class="block mb-2 text-sm font-medium text-gray-900">RFC:</label>
                                        <input type="text" id="rfc" value="{{ $selectedWorker->rfc }}"
                                            readonly
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-100">

                                        <label for="nombre"
                                            class="block mb-2 text-sm font-medium text-gray-900">Nombre:</label>
                                        <input type="text" id="nombre" value="{{ $selectedWorker->nombre }}"
                                            readonly
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-100">

                                        <label for="area"
                                            class="block mb-2 text-sm font-medium text-gray-900">Área:</label>
                                        <input type="text" id="area" value="{{ $selectedWorker->area }}"
                                            readonly
                                            class="shadow-sm text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-gray-100">
                                    </div>
                                @endif
                            </div>


                        </x-slot>

                        <x-slot name="footer">
                            <x-button wire:click="closeBajaPersonal">
                                Cerrar
                            </x-button>

                            <x-danger-button type="button" class="ml-2" wire:click="bajaPersonal"
                                wire:loading.attr="disabled">
                                Baja
                            </x-danger-button>
                        </x-slot>
                    </x-dialog-modal>

                    <!-- Modal de historial-->
                    <x-dialog-modal wire:model="historial" maxWidth="6xl">
                        <x-slot name="title">
                            historial de bienes
                        </x-slot>

                        <x-slot name="content">
                            <div class="overflow-auto max-h-[500px]">
                                @if ($historial)
                                    <table class="min-w-full bg-white">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-2">Folio</th>
                                                <th class="px-4 py-2">Tipo Movimiento</th>
                                                <th class="px-4 py-2">Fecha</th>
                                                <th class="px-4 py-2">Descripción</th>
                                                <th class="px-4 py-2">Modelo</th>
                                                <th class="px-4 py-2">Marca</th>
                                                <th class="px-4 py-2">Numero de Serie</th>
                                                <th class="px-4 py-2">Numero de Inventario</th>
                                                <th class="px-4 py-2">Observaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($historial as $registro)
                                                <tr>
                                                    <td
                                                        class="border px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $registro['folio'] }}
                                                    </td>
                                                    <td
                                                        class="border px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $registro['tipo_movimiento'] }}
                                                    </td>
                                                    <td
                                                        class="border px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{-- {{ $registro['fecha'] }} --}}
                                                        {{ \Carbon\Carbon::parse($registro['fecha'])->format('d-m-Y') }}
                                                    </td>

                                                    <td
                                                        class="border px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $registro['descripcion'] }}
                                                    </td>
                                                    <td
                                                        class="border px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $registro['modelo'] }}
                                                    </td>
                                                    <td
                                                        class="border px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $registro['marca'] }}
                                                    </td>

                                                    <td
                                                        class="border px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $registro['numero_serie'] }}
                                                    </td>
                                                    <td
                                                        class="border px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $registro['numero_inventario'] }}
                                                    </td>

                                                    <td
                                                        class="border px-3 py-3 whitespace-normal text-sm font-medium text-gray-900">
                                                        {{ $registro['observaciones'] }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif

                            </div>


                        </x-slot>

                        <x-slot name="footer">
                            <x-button wire:click="closeBienesResguistro">
                                Cerrar
                            </x-button>


                        </x-slot>
                    </x-dialog-modal>
                </div>
                <!-- Agregar el paginador -->
                <!-- Agregar el paginador -->
                <div class="my-2 mx-2">
                    {{ $listaPersonal->links() }}
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('swal', (event) => {
            //alert('123')
            const data = event
            Swal.fire({
                title: data[0]['title'],
                text: data[0]['text'],
                icon: data[0]['icon'],
            });
        })

        @this.on('delete-prompt', (event) => {
            //alert('345')
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.dispatch('goOn-Delete')
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                }
            });
        })
    })
</script>
