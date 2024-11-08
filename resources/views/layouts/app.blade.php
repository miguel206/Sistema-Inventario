<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Inventario') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <!-- Styles -->
    @livewireStyles
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

{{-- <body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        
        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')


    <script>
        $(function() {
            $('.select2').select2({
                placeholder: 'seleccion de personal',
                width: '625px'
            })
        })
    </script>

    <script>
        $(document).ready(function() {
            $('.select2multi').select2({
                placeholder: 'seleccion de bienes',
                width: '625px',
            });
        });
    </script>




    @livewireScripts
</body> --}}

{{-- <body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100 flex">
        <!-- Sidebar -->
        
            <div class="w-48 bg-white shadow-lg">
            <nav class="flex flex-col p-4">
                <a href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="py-2 px-4 text-gray-700 hover:bg-gray-200">Movimientos</a>
                <a href="{{ route('bienes') }}" class="py-2 px-4 text-gray-700 hover:bg-gray-200">Bienes</a>
                <a href="{{ route('personal') }}" class="py-2 px-4 text-gray-700 hover:bg-gray-200">Personal</a>
                <!-- Add more links as needed -->
            </nav>
            
        </div>

        <div class="flex-1">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('modals')

    <!-- Select2 Scripts -->
    <script>
        $(function() {
            $('.select2').select2({
                placeholder: 'seleccion de personal',
                width: '625px'
            });
        });

        $(document).ready(function() {
            $('.select2multi').select2({
                placeholder: 'seleccion de bienes',
                width: '625px',
            });
        });
    </script>

    @livewireScripts
</body> --}}

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100 flex">
        <!-- Sidebar -->
        <!-- ========== Start Section ========== -->
        <x-side-bar />
        <!-- ========== End Section ========== -->
        
        <div class="flex-1">

            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('modals')

    <!-- Select2 Scripts -->
    <script>
        $(function() {
            $('.select2').select2({
                placeholder: 'seleccion de personal',
                width: '625px'
            });
        });

        $(document).ready(function() {
            $('.select2multi').select2({
                placeholder: 'seleccion de bienes',
                width: '625px',
            });
        });
    </script>

    @livewireScripts
</body>





</html>
