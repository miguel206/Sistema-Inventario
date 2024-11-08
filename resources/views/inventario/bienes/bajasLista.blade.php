<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventario') }}
        </h2>
    </x-slot> --}}
    <div class="px-8 pt-2 hidden sm:flex sm:items-center sm:space-x-6">
        <x-nav-link class="py-2 px-4 rounded-md text-black bg-pink-200 hover:bg-pink-300" href="{{ route('bienes') }}"
            :active="request()->routeIs('bienes')">
            {{ __('Bienes') }}
        </x-nav-link>

        <x-nav-link class="py-2 px-4 rounded-md text-white bg-pink-500 hover:bg-pink-600" href="{{ route('bajas') }}"
            :active="request()->routeIs('bajas')">
            {{ __('bajas') }}
        </x-nav-link>
    </div>

    <div class="py-4">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('bienes.registros-eliminados')
            </div>
        </div>
    </div>
</x-app-layout>
