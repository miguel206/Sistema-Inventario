<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formato de Préstamo de Equipo</title>

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
    <!-- Agrega tu propio CSS personalizado para imitar los estilos de Tailwind -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .header,
        .content {
            margin-bottom: 20px;
        }

        .header {
            text-align: center;
        }

        .content p {
            margin: 10px 0;
        }

        .strong {
            font-weight: bold;
        }

        /* Contenedor general */
        .m-4 {
            margin: 1rem;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .shadow-md {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .bg-gray-200 {
            background-color: #edf2f7;
        }

        .pt-2 {
            padding-top: 0.5rem;
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .mt-8 {
            margin-top: 2rem;
        }

        /* Títulos */
        .text-lg {
            font-size: 1.125rem;
        }

        .font-semibold {
            font-weight: 600;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        /* Flexbox para alinear horizontalmente */
        .content {
            display: flex;
            gap: 1rem;
            /* Espacio entre elementos */
            align-items: center;
            /* Alinea verticalmente los elementos */
        }

        /* Tabla */
        .min-w-full {
            min-width: 100%;
        }

        .w-full {
            width: 100%;
        }

        .divide-y {
            border-collapse: collapse;
        }

        .divide-gray-200 {
            border-color: #edf2f7;
        }

        .bg-gray-300 {
            background-color: #e2e8f0;
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .text-left {
            text-align: left;
        }

        .text-xs {
            font-size: 0.75rem;
        }

        .font-medium {
            font-weight: 500;
        }

        .text-gray-700 {
            color: #4a5568;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .tracking-wider {
            letter-spacing: 0.05em;
        }

        .hover\:bg-gray-100:hover {
            background-color: #f7fafc;
        }

        .whitespace-nowrap {
            white-space: nowrap;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .font-medium {
            font-weight: 500;
        }

        .text-gray-900 {
            color: #1a202c;
        }

        .px-2 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .py-1 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }

        .rounded-full {
            border-radius: 9999px;
        }

        .text-white {
            color: white;
        }

        .bg-green-500 {
            background-color: #48bb78;
        }

        .bg-yellow-500 {
            background-color: #ecc94b;
        }

        .bg-red-500 {
            background-color: #f56565;
        }

        .bg-gray-500 {
            background-color: #a0aec0;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="p-6">
            <div class="header">
                <h1>Formato de Préstamo de Equipo</h1>
                <p>Instituto de Elecciones y Participación Ciudadana</p>
                <p>Secretaría Ejecutiva</p>
                <p>Unidad de Servicios Informáticos Electorales</p>
            </div>


            <div class="form-group">
                <div class="content">
                    <h2 class="text-lg font-semibold">Folio: {{ $movimiento->folio }}</h2>
                    <p><strong>Estado:</strong>
                        <span
                            class="px-2 py-1 rounded-full text-white
                            @if ($movimiento->estado == 'COMPLETO') bg-green-500
                            @elseif ($movimiento->estado == 'PARCIAL') bg-yellow-500
                            @elseif ($movimiento->estado == 'TERMINADO' || $movimiento->estado == 'CANCELADO') bg-red-500
                            @elseif ($movimiento->estado == 'N/A') bg-gray-500 @endif">
                            {{ $movimiento->estado }}
                        </span>
                    </p>
                    <p><span class="strong">Fecha:</span>
                        {{ \Carbon\Carbon::parse($movimiento->fecha)->format('d-m-Y') }}</p>
                </div>
                <div class="m-4">
                    <div class="overflow-hidden rounded-lg shadow-md bg-gray-200 pt-2">
                        <div class="px-6">
                            <h2 class="text-lg font-semibold mb-2">Detalles del Bien</h2>
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
                                            Descripción
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
                                            Fecha de resguardo
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($movimiento->bien as $bien)
                                        <tr class="hover:bg-gray-100" wire:key="{{ $bien->id }}">
                                            <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $bien->numero_inventario }}
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $bien->numero_serie }}
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
                                            <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ \Carbon\Carbon::parse($movimiento->fecha)->format('d-m-Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($movimiento->estado === 'PARCIAL' || $movimiento->estado === 'TERMINADO' || $movimiento->estado === 'CANCELADO')
                        <div class="overflow-hidden rounded-lg shadow-md bg-gray-200 mt-8 pt-2">
                            <div class="px-6">
                                <h2 class="text-lg font-semibold mb-2">Bienes Devueltos</h2>
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
                                                Descripción
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
                                                Fecha de resguardo
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($movimiento->bienDevueltos && $movimiento->bienDevueltos->count() > 0)
                                            @foreach ($movimiento->bienDevueltos as $bien)
                                                <tr class="hover:bg-gray-100" wire:key="{{ $bien->id }}">
                                                    <td
                                                        class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $bien->numero_inventario }}
                                                    </td>
                                                    <td
                                                        class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $bien->numero_serie }}
                                                    </td>
                                                    <td
                                                        class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $bien->descripcion }}
                                                    </td>
                                                    <td
                                                        class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $bien->modelo }}
                                                    </td>
                                                    <td
                                                        class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $bien->marca }}
                                                    </td>
                                                    <td
                                                        class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ \Carbon\Carbon::parse($movimiento->fecha)->format('d-m-Y') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6"
                                                    class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    No hay bienes devueltos
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
                <p><span class="strong">Solicitante:</span> {{ $movimiento->personal->nombre }}</p>
                <p><span class="strong">Abscripción:</span> {{ $movimiento->personal->area }}</p>
                <p><span class="strong">Cantidad de bienes:</span> {{ intval($movimiento->cantidad) }}
                </p>
                <p><span class="strong">Observaciones:</span>
                    @if ($movimiento->observaciones)
                        {{ $movimiento->observaciones }}
                    @else
                        Sin Observaciones
                    @endif
                </p>
            </div>
        </div>
    </div>
</body>

</html>
