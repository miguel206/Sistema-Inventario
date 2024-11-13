<div>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full sm:px-6 lg:px-8 bg-gray-200">
                <div class="overflow-hidden rounded-lg shadow-md bg-gray-200 ">
                    <h1 class="px-6 pt-3 text-center text-2xl font-bold text-gray-800 tracking-wider">
                        Lista de Resguardos de Bienes</h1>

                    <div class="flex justify-between mb-2">
                        <div class="flex">
                            <div class="flex">

                                <div class="px-4">
                                    @livewire('movimientos.resguardo.resguardo')
                                </div>

                                {{-- <select class="mx-4 pl-2 pr-8 rounded-md" wire:model.live="opcionSeleccionada">
                                    <option value="">Seleccionar Movimiento</option>
                                    @hasanyrole('admin|supervisor|soporte')
                                        <option value="resguardo">Préstamo de Equipo</option>
                                    @endhasanyrole

                                    @hasanyrole('admin|supervisor')
                                        <option value="devolucion">Devolución de Equipo</option>
                                        <option value="bienes">Agregar Bienes </option>
                                        <option value="ingresar">Registro Personal</option>
                                        <option value="cancelar">Cancelar Resguardo</option>
                                    @endhasanyrole
                                </select> --}}
                            </div>
                        </div>





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
                        <thead class=" bg-gray-300">
                            <tr>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-sm bold font-medium text-black tracking-wider">
                                    Número de Folio
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-sm bold font-medium text-black tracking-wider">
                                    Tipo de Movimiento
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-sm bold font-medium text-black tracking-wider">
                                    Fecha
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-sm bold font-medium text-black tracking-wider">
                                    Solicitante
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-sm bold font-medium text-black tracking-wider">
                                    Adscripción
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-sm bold font-medium text-black tracking-wider">
                                    Estado
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-center text-sm bold font-medium text-black tracking-wider">
                                    Observaciones
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-sm bold font-medium text-black tracking-wider">

                                </th>

                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($movimientosListas as $movimiento)
                                <tr class="hover:bg-gray-100" wire:key="{{ $movimiento->id }}">
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        @if ($movimiento->tipo_moviento === 'RESGUARDO')
                                            <a href="{{ route('detallesFolios', ['id' => $movimiento->id]) }}">
                                                <p class="text-gray-900 hover:text-blue-500 hover:underline">
                                                    <strong>{{ $movimiento->folio }}</strong>
                                                </p>
                                            </a>
                                        @else
                                            <strong>{{ $movimiento->folio }}</strong>
                                        @endif

                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{-- {{ $movimiento->tipo_moviento }} --}}

                                        @if ($movimiento->tipo_moviento == 'RESGUARDO')
                                            <p>RESGUARDO</p>
                                        @elseif($movimiento->tipo_moviento == 'DEVOLUCION')
                                            <p>DEVOLUCIÓN</p>
                                        @elseif($movimiento->tipo_moviento == 'ACTUALIZACION')
                                            <p>ACTUALIZACIÓN</p>
                                        @else
                                            {{ $movimiento->tipo_moviento }}
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{-- {{ $movimiento->fecha }} --}}
                                        {{ \Carbon\Carbon::parse($movimiento->fecha)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-3 py-3 whitespace-normal text-sm font-medium text-gray-900 ">
                                        {{-- {{ $movimiento->personal->nombre }} --}}
                                        @if ($movimiento->personal)
                                            {{-- {{ $movimiento->personal->nombre ?? 'Sin asignar' }} --}}
                                            {{-- {{ $movimiento->personal->nombre }} --}}
                                            <a
                                                href="{{ route('personal.detalle', ['id' => $movimiento->personal->id]) }}">
                                                <p class="text-gray-900 hover:text-blue-500 hover:underline">
                                                    <strong>{{ $movimiento->personal->nombre }}</strong>
                                                </p>
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 whitespace-normal text-sm font-medium text-gray-900">
                                        {{-- {{ $movimiento->personal->nombre }} --}}
                                        @if ($movimiento->personal)
                                            {{-- {{ $movimiento->personal->nombre ?? 'Sin asignar' }} --}}
                                            {{-- {{ $movimiento->personal->nombre }} --}}
                                            {{ $movimiento->personal->area }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 
                                        @if ($movimiento->estado == 'COMPLETO') bg-green-500
                                        @elseif ($movimiento->estado == 'PARCIAL') bg-yellow-500
                                        @elseif ($movimiento->estado == 'TERMINADO' || $movimiento->estado == 'CANCELADO') bg-red-500 @endif">
                                        {{-- <span
                            class="px-2 py-1 rounded-full text-white 
                            @if ($movimiento->estado == 'COMPLETO') bg-green-500
                            @elseif ($movimiento->estado == 'PARCIAL') bg-yellow-500
                            @elseif ($movimiento->estado == 'TERMINADO' || $movimiento->estado == 'CANCELADO') bg-red-500
                            @elseif ($movimiento->estado == 'N/A') bg-gray-500 @endif">
                            {{ $movimiento->estado }}
                        </span> --}}
                                        {{ $movimiento->estado }}
                                    </td>
                                    <td
                                        class="px-3 py-3 whitespace-normal text-center text-sm font-medium text-gray-900">
                                        {{-- {{ $movimiento->observaciones }} --}}
                                        @if ($movimiento->observaciones)
                                            {{ $movimiento->observaciones }}
                                        @else
                                            Sin Observaciones
                                        @endif
                                    </td>


                                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <x-button wire:click="openModalBienes({{ $movimiento->id }})"
                                            class=" bg-slate-600 px-1"><svg xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                                <path fill-rule="evenodd"
                                                    d="M15.988 3.012A2.25 2.25 0 0 1 18 5.25v6.5A2.25 2.25 0 0 1 15.75 14H13.5V7A2.5 2.5 0 0 0 11 4.5H8.128a2.252 2.252 0 0 1 1.884-1.488A2.25 2.25 0 0 1 12.25 1h1.5a2.25 2.25 0 0 1 2.238 2.012ZM11.5 3.25a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 .75.75v.25h-3v-.25Z"
                                                    clip-rule="evenodd" />
                                                <path fill-rule="evenodd"
                                                    d="M2 7a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7Zm2 3.25a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Zm0 3.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </x-button>

                                        @if ($movimiento->tipo_moviento == 'RESGUARDO')
                                            <a href="{{ route('generaPDF', ['id' => $movimiento->id]) }}">
                                                <x-button class=" bg-yellow-500 px-1"><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="size-5">
                                                        <path
                                                            d="M10.75 2.75a.75.75 0 0 0-1.5 0v8.614L6.295 8.235a.75.75 0 1 0-1.09 1.03l4.25 4.5a.75.75 0 0 0 1.09 0l4.25-4.5a.75.75 0 0 0-1.09-1.03l-2.955 3.129V2.75Z" />
                                                        <path
                                                            d="M3.5 12.75a.75.75 0 0 0-1.5 0v2.5A2.75 2.75 0 0 0 4.75 18h10.5A2.75 2.75 0 0 0 18 15.25v-2.5a.75.75 0 0 0-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5Z" />
                                                    </svg>

                                                </x-button>
                                            </a>
                                        @else
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Modal de detalles del bien -->
                    <x-dialog-modal wire:model="showModalview">
                        <x-slot name="title">
                            datos del bien
                        </x-slot>

                        <x-slot name="content">
                            <div class="p-4">

                                @if ($bienInfo)
                                    <p><strong>Número de Inventario:</strong> {{ $bienInfo->numero_inventario }}</p>
                                    <p><strong>Número de Serie:</strong> {{ $bienInfo->numero_serie }}</p>
                                    <p><strong>Descripción:</strong> {{ $bienInfo->descripcion }}</p>
                                    <p><strong>Modelo:</strong> {{ $bienInfo->modelo }}</p>
                                    <p><strong>Marca:</strong> {{ $bienInfo->marca }}</p>
                                    <p><strong>Precio:</strong> {{ $bienInfo->precio }}</p>
                                    <p><strong>Factura:</strong> {{ $bienInfo->factura }}</p>
                                    <p><strong>Estatus:</strong> {{ $bienInfo->estado }}</p>
                                    <p><strong>Observaciones:</strong>
                                        @if ($bienInfo->observaciones)
                                            {{ $bienInfo->observaciones }}
                                        @else
                                            Sin observaciones
                                        @endif
                                    </p>

                                    @if ($bienInfo->estado == 'RESGUARDO')
                                        <div class="py-2 my-2 bg-orange-200 rounded-md">

                                            <div class="px-4 py-3 text-left text-gray-700">
                                                <h3 class=" font-medium tracking-wider">Bien en resguardo de:</h3>
                                                <p
                                                    class="text-left py-1 text-xl font-medium text-gray-700 uppercase tracking-wider">
                                                    RFC:
                                                    <strong>{{ $bienInfo->personal->rfc }}</strong>
                                                </p>
                                                <p
                                                    class="text-left py-1 text-xl font-medium text-gray-700 uppercase tracking-wider">
                                                    Nombre:
                                                    <strong>{{ $bienInfo->personal->nombre }}</strong>
                                                </p>
                                                <p
                                                    class="text-left py-1 text-xl font-medium text-gray-700 uppercase tracking-wider">
                                                    Área:
                                                    <strong>{{ $bienInfo->personal->area }}</strong>
                                                </p>
                                            </div>
                                        </div>
                                    @else
                                        <div class=" flex justify-center my-3 py-3 bg-gray-200 rounded-md text-xl">
                                            Sin
                                            resguardo activo</div>
                                    @endif

                                @endif

                            </div>

                        </x-slot>

                        <x-slot name="footer">
                            <x-button wire:click="closeModalView">
                                Cancelar
                            </x-button>
                        </x-slot>
                    </x-dialog-modal>

                    <!-- Modal de bienes en folio-->
                    <x-dialog-modal wire:model="showModalBienes" maxWidth="6xl">
                        <x-slot name="title">
                            bienes del folio
                        </x-slot>


                        <x-slot name="content">
                            @if (empty($bienesInfo))
                                <div class="text-gray-500 text-center py-4">
                                    No aplica
                                </div>
                            @else
                                <div class="overflow-auto max-h-[500px]">

                                    <table class="min-w-full bg-white">
                                        <!-- Encabezados de la tabla -->
                                        <thead class="">
                                            <!-- Encabezados de las columnas -->
                                            <tr>

                                                <th class="px-4 py-2 uppercase">
                                                    Descripción
                                                </th>
                                                <th class="px-4 py-2 uppercase">
                                                    MODELO
                                                </th>
                                                <th class="px-4 py-2 uppercase">
                                                    MARCA
                                                </th>
                                                <th class="px-4 py-2 uppercase">
                                                    Num. Inventario
                                                </th>
                                                <th class="px-4 py-2 uppercase">
                                                    # Serie
                                                </th>
                                                <th class="px-4 py-2 uppercase">
                                                    OBSERVACION
                                                </th>
                                                <!-- Agrega más columnas según la información que quieras mostrar -->
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <!-- Filas de la tabla -->
                                            @foreach ($bienesInfo as $bien)
                                                <tr>
                                                    <!-- Celdas de cada fila -->

                                                    <td class="border px-4 py-2">
                                                        {{ $bien->descripcion }}
                                                        {{-- <a
                                                            href="{{ route('bienes.detalle', ['id' => $bien->id]) }}">{{ $bien->descripcion }}</a> --}}
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        {{ $bien->modelo }}
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        {{ $bien->marca }}
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        @if ($bien->numero_inventario)
                                                            <a
                                                                href="{{ route('bienes.detalle', ['id' => $bien->id]) }}">
                                                                <strong>
                                                                    <P
                                                                        class="text-gray-900 hover:text-blue-500 hover:underline">
                                                                        {{ $bien->numero_inventario }} </P>
                                                                </strong>
                                                            </a>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td class="border px-4 py-2">

                                                        @if ($bien->numero_serie)
                                                            <a
                                                                href="{{ route('bienes.detalle', ['id' => $bien->id]) }}">
                                                                <strong>
                                                                    <P
                                                                        class="text-gray-900 hover:text-blue-500 hover:underline">
                                                                        {{ $bien->numero_serie }} </P>
                                                                </strong>
                                                            </a>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td class="border px-4 py-2 whitespace-normal">

                                                        @if ($bien->observaciones)
                                                            {{ $bien->observaciones }}
                                                        @else
                                                            Sin Observaciones
                                                        @endif
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
                                                    <!-- Agrega más celdas según la información que quieras mostrar -->
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </x-slot>

                        <x-slot name="footer">
                            <x-button wire:click="closeModalBienes">
                                Cancelar
                            </x-button>

                        </x-slot>
                    </x-dialog-modal>


                </div>
                <!-- Agregar el paginador -->
                <div class="my-2 mx-2">
                    {{ $movimientosListas->links() }}
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

            //@this.on('swalConfirmation', (event) => {
            Swal.fire({
                title: "¿Guardar bienes?",
                text: "Los bienes ingresados se daran de alta en el sistema",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, guardar",
                cancelButtonText: "Cancelar"

            }).then((result) => {
                if (result.isConfirmed) {

                    @this.dispatch('go-submit')

                    // Swal.fire({
                    //     title: "Registro correcto",
                    //     text: "Se dio de alta los bienes en el sistema",
                    //     icon: "success"
                    // });
                }
            });
        })

        @this.on('confirm-prestamo', (event) => {

            //@this.on('swalConfirmation', (event) => {
            Swal.fire({
                title: "¿Realizar resguardo?",
                text: "Se registrara el prestamo de los bienes en el inventario",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, Realizar resguardo",
                cancelButtonText: "Cancelar"

            }).then((result) => {
                if (result.isConfirmed) {

                    @this.dispatch('go-submit-prestamo')

                    // Swal.fire({
                    //     title: "Registro correcto",
                    //     text: "Se dio de alta los bienes en el sistema",
                    //     icon: "success"
                    // });
                }
            });
        })

        @this.on('confirm-presonal', (event) => {

            //@this.on('swalConfirmation', (event) => {
            Swal.fire({
                title: "¿Realizar Registro?",
                text: "Se registrara el personal en el sistema",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, Realizar Registro",
                cancelButtonText: "Cancelar"

            }).then((result) => {
                if (result.isConfirmed) {

                    @this.dispatch('go-submit-Registro')

                    // Swal.fire({
                    //     title: "Registro correcto",
                    //     text: "Se dio de alta los bienes en el sistema",
                    //     icon: "success"
                    // });
                }
            });
        })

        @this.on('confirm-devolucion', (event) => {

            //@this.on('swalConfirmation', (event) => {
            Swal.fire({
                title: "¿Realizar Devolución?",
                text: "Se registrara la devolución de los bienes seleccionados",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, Realizar Devolución",
                cancelButtonText: "Cancelar"

            }).then((result) => {
                if (result.isConfirmed) {

                    @this.dispatch('go-submit-devolucion')
                }
            });
        })
    })
</script>
