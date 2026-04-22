<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Unit Management') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($units as $unit)
                        <div class="border rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                            <div class="p-4 bg-teal-800 text-white flex justify-between items-center">
                                <span class="text-lg font-bold">Unit {{ $unit->unit_number }}</span>
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $unit->type == 'AC' ? 'bg-blue-500' : 'bg-orange-500' }}">
                                    {{ $unit->type }}
                                </span>
                            </div>
                            <div class="p-4">
                                <p class="text-sm text-gray-600 mb-1">Floor: <strong>{{ $unit->floor }}</strong></p>
                                <p class="text-sm text-gray-600 mb-1">Rent: <strong>₱{{ number_format($unit->base_rent, 2) }}</strong></p>
                                <p class="text-sm mb-4">
                                    Status: 
                                    <span class="font-bold {{ $unit->status == 'Vacant' ? 'text-green-600' : ($unit->status == 'Occupied' ? 'text-red-600' : 'text-orange-600') }}">
                                        {{ $unit->status }}
                                    </span>
                                </p>
                                <div class="flex justify-end">
                                    <a href="{{ route('units.edit', $unit->id) }}" class="text-teal-700 hover:text-teal-900 text-sm font-semibold flex items-center">
                                        Edit Unit →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
