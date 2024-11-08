<div class="px-8 pt-2 hidden sm:flex sm:items-center sm:space-x-6">
 

    @switch(true)
        @case(request()->routeIs('resguardos'))
            <x-nav-link class="py-2 px-4 rounded-md text-white bg-pink-300 hover:bg-pink-300" href="{{ route('dashboard') }}"
                :active="request()->routeIs('dashboard')">
                {{ __('Movimientos') }}
            </x-nav-link>

            <x-nav-link class="py-2 px-4 rounded-md text-black bg-pink-500 hover:bg-pink-600" href="{{ route('resguardos') }}"
                :active="request()->routeIs('resguardos')">
                {{ __('Prestamos') }}
            </x-nav-link>

            <x-nav-link class="py-2 px-4 rounded-md text-black bg-pink-300 hover:bg-pink-300" href="{{ route('devolucion_bienes') }}"
                :active="request()->routeIs('devolucion_bienes')">
                {{ __('Devolución') }}
            </x-nav-link>

            <x-nav-link class="py-2 px-4 rounded-md text-white bg-pink-300 hover:bg-pink-300" href="{{ route('Alta_Bienes') }}"
                :active="request()->routeIs('Alta_Bienes')">
                {{ __('Alta de Bienes') }}
            </x-nav-link>
        @break

        @case(request()->routeIs('Alta_Bienes'))
            <x-nav-link class="py-2 px-4 rounded-md text-black bg-pink-300 hover:bg-pink-400" href="{{ route('dashboard') }}"
                :active="request()->routeIs('dashboard')">
                {{ __('Movimientos') }}
            </x-nav-link>

            <x-nav-link class="py-2 px-4 rounded-md text-black bg-pink-300 hover:bg-pink-400" href="{{ route('resguardos') }}"
                :active="request()->routeIs('resguardos')">
                {{ __('Prestamos') }}
            </x-nav-link>

            <x-nav-link class="py-2 px-4 rounded-md text-black bg-pink-300 hover:bg-pink-300" href="{{ route('devolucion_bienes') }}"
                :active="request()->routeIs('devolucion_bienes')">
                {{ __('Devolución') }}
            </x-nav-link>

            <x-nav-link class="py-2 px-4 rounded-md text-black bg-pink-500 hover:bg-pink-600" href="{{ route('Alta_Bienes') }}"
                :active="request()->routeIs('Alta_Bienes')">
                {{ __('Alta de Bienes') }}
            </x-nav-link>
        @break

        @case(request()->routeIs('devolucion_bienes'))
            <x-nav-link class="py-2 px-4 rounded-md text-black bg-pink-300 hover:bg-pink-400" href="{{ route('dashboard') }}"
                :active="request()->routeIs('dashboard')">
                {{ __('Movimientos') }}
            </x-nav-link>

            <x-nav-link class="py-2 px-4 rounded-md text-black bg-pink-300 hover:bg-pink-400" href="{{ route('resguardos') }}"
                :active="request()->routeIs('resguardos')">
                {{ __('Prestamos') }}
            </x-nav-link>

            <x-nav-link  class="py-2 px-4 rounded-md text-black bg-pink-500 hover:bg-pink-600"  href="{{ route('devolucion_bienes') }}"
                :active="request()->routeIs('devolucion_bienes')">
                {{ __('Devolución') }}
            </x-nav-link>

            <x-nav-link class="py-2 px-4 rounded-md text-black bg-pink-300 hover:bg-pink-400" href="{{ route('Alta_Bienes') }}"
                :active="request()->routeIs('Alta_Bienes')">
                {{ __('Alta de Bienes') }}
            </x-nav-link>
        @break

        @default
            <x-nav-link class="py-2 px-4 rounded-md text-black bg-pink-500 hover:bg-pink-600" href="{{ route('dashboard') }}"
                :active="request()->routeIs('dashboard')">
                {{ __('Movimientos') }}
            </x-nav-link>


            <x-nav-link class="py-2 px-4 rounded-md text-black bg-pink-300 hover:bg-pink-300" href="{{ route('resguardos') }}"
                :active="request()->routeIs('resguardos')">
                {{ __('Préstamo') }}
            </x-nav-link>

            <x-nav-link class="py-2 px-4 rounded-md text-black bg-pink-300 hover:bg-pink-300" href="{{ route('devolucion_bienes') }}"
                :active="request()->routeIs('devolucion_bienes')">
                {{ __('Devolución') }}
            </x-nav-link>

            <x-nav-link class="py-2 px-4 rounded-md text-black bg-pink-300 hover:bg-pink-300" href="{{ route('Alta_Bienes') }}"
                :active="request()->routeIs('Alta_Bienes')">
                {{ __('Alta de Bienes') }}
            </x-nav-link>

            
    @endswitch
</div>
