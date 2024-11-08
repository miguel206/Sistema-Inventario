<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Personal') }}
        </h2>
    </x-slot> --}}

    {{-- <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <x-nav-link class=" bg-pink-500 border-b-4 mt-2" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            {{ __('<- Movimientos') }}
        </x-nav-link>  
    </div> --}}

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('Bienes.detalle-bien', ['id' => $bienes->id])

            </div>
        </div>
    </div>
</x-app-layout>