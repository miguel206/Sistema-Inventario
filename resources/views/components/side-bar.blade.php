<div class=" w-44 bg-white shadow-lg">
    <nav class="flex flex-col p-4">

        <div class="relative group">
            <!-- Enlace Movimientos -->
            @switch(true)
                @case(request()->routeIs('resguardos'))
                    <a href="{{ route('dashboard') }}"
                        class="block py-2 px-4 text-gray-700 hover:bg-gray-200 bg-gray-300 font-bold rounded-lg">
                        Movimientos

                    </a>
                @break

                @case(request()->routeIs('Alta_Bienes'))
                    <a href="{{ route('dashboard') }}"
                        class="block py-2 px-4 text-gray-700 hover:bg-gray-200 bg-gray-300 font-bold rounded-lg">
                        Movimientos
                    </a>
                @break

                @case(request()->routeIs('devolucion_bienes'))
                    <a href="{{ route('dashboard') }}"
                        class="block py-2 px-4 text-gray-700 hover:bg-gray-200 bg-gray-300 font-bold rounded-lg">
                        Movimientos
                    </a>
                @break

                @default
                    <a href="{{ route('dashboard') }}"
                        class="block py-2 px-4 text-gray-700 hover:bg-gray-200 rounded-lg
                       @if (request()->routeIs('dashboard')) bg-gray-300 font-bold rounded-lg @endif">
                        Movimientos
                    </a>
            @endswitch

            <!-- Menú desplegable que aparece al hacer hover -->
            <div class="absolute hidden group-hover:block bg-gray-300 shadow-lg rounded-lg">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">
                    - Panel
                </a>
                <a href="{{ route('resguardos') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">
                    - Prestamos
                </a>
                <a href="{{ route('devolucion_bienes') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">
                    - Devolución de bienes
                </a>
                <a href="{{ route('Alta_Bienes') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">
                    - Alta de Bienes
                </a>

            </div>
        </div>


        <!-- Las demás opciones del menú, que se posicionan debajo del submenú -->
        @switch(true)
            @case(request()->routeIs('bajas'))
                <a href="{{ route('resguardos') }}"
                    class="py-2 px-4 text-gray-700 hover:bg-gray-200 bg-gray-300 font-bold rounded-lg">
                    Bienes
                </a>
            @break

            @default
                <a href="{{ route('bienes') }}"
                    class="py-2 px-4 text-gray-700 hover:bg-gray-200 rounded-lg
                    @if (request()->routeIs('bienes')) bg-gray-300 font-bold rounded-lg @endif">
                    Bienes
                </a>
        @endswitch


        <a href="{{ route('personal') }}"
            class="py-2 px-4 text-gray-700 hover:bg-gray-200 rounded-lg
            @if (request()->routeIs('personal')) bg-gray-300 font-bold rounded-lg @endif">
            Personal
        </a>
    </nav>


</div>
