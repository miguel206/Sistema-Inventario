<div>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full sm:px-6 lg:px-8 bg-gray-200">
                <div class="overflow-hidden rounded-lg shadow-md bg-gray-200 ">
                    <h1 class="px-6 pt-3 text-center text-2xl font-bold text-gray-800 tracking-wider">
                        Alta de Bienes</h1>

                    <div class="flex justify-between mb-2">
                        <div class="flex">
                            <div class="flex">

                                <div class="px-4">
                                    {{-- @livewire('movimientos.resguardo.resguardo') --}}
                                    {{-- @livewire('bienes.crear-dinamico') --}}
                                    @livewire('bienes.alta-bienes')
                                </div>

                            </div>
                        </div>





                        <div class="flex justify-between">
                            <div class="flex items-center">
                                <input type="text" wire:model.live="search" placeholder="Buscar..."
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-64 p-2 rounded-md mr-4">
                                <select class="pl-2 pr-8 rounded-md py-2 mr-4" wire:model.live="paginateDinamico">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    @foreach ($movimientosAgrupados as $folio => $movimientoData)
                        <div class="mb-6 mx-2 rounded-lg  shadow-md">
                            <div class="flex bg-gray-200">
                                <div>
                                    <p class="px-3 py-2 text-xl font-semibold text-gray-800">Fecha:
                                        {{ $movimientoData['fecha'] }}</p>
                                </div>
                                <div>
                                    <h2 class="px-3 py-2 text-xl font-semibold text-gray-800">Folio: {{ $folio }}
                                    </h2>
                                </div>
                            </div>

                            <table class="min-w-full w-full divide-y divide-gray-200">
                                <thead class="bg-gray-300">
                                    <tr>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-sm font-medium text-black tracking-wider">
                                            Descripción
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-sm font-medium text-black tracking-wider">
                                            Modelo
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-sm font-medium text-black tracking-wider">
                                            Marca
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-sm font-medium text-black tracking-wider">
                                            Número de Inventario
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-sm font-medium text-black tracking-wider">
                                            Número de Serie
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-sm font-medium text-black tracking-wider">

                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($movimientoData['biens'] as $bien)
                                        <tr>
                                            <td class="px-3 py-2 text-sm text-gray-900">
                                                {{ $bien->descripcion }}</td>
                                            <td class="px-3 py-2 text-sm text-gray-900">{{ $bien->modelo }}
                                            </td>
                                            <td class="px-3 py-2 text-sm text-gray-900">{{ $bien->marca }}
                                            </td>

                                            <td class="px-3 py-2 text-sm text-gray-900">

                                                @if ($bien->numero_inventario)
                                                    {{ $bien->numero_inventario }}
                                                @else
                                                    S/N
                                                @endif

                                            </td>
                                            <td class="px-3 py-2 text-sm text-gray-900">

                                                @if ($bien->numero_serie)
                                                    {{ $bien->numero_serie }}
                                                @else
                                                    S/N
                                                @endif

                                            </td>

                                            <td class="px-3 py-2 text-sm text-gray-900">
                                                <a
                                                    href="{{ route('bienes', ['search' => $bien->numero_inventario ?: $bien->numero_serie]) }}">
                                                    <x-button class="bg-green-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="size-5">
                                                            <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                                            <path fill-rule="evenodd"
                                                                d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </x-button>
                                                </a>


                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach



                    <!-- Paginador -->
                    <div class="my-2 mx-2">
                        {{ $movimientosPaginados->links() }}
                    </div>


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

        @this.on('submitAltas-prompt', (event) => {

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

                    @this.dispatch('go-submitAltas')

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
                title: "¿Realizar prestamo?",
                text: "Se registrara el prestamo de los bienes en el inventario",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, Realizar prestamo",
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
    })
</script>
