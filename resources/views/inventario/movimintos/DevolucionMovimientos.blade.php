<x-app-layout>
    

    <x-movimientos.nav_links />
    
    <div class="py-4">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- @livewire('movimientos.bienes.tabla-altas') --}}
                @livewire('movimientos.bienes.tabla-devolucion')
            </div>
        </div>
    </div>
</x-app-layout>