<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit Unit ') . $unit->unit_number }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('units.update', $unit->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Unit Type</label>
                        <select name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                            <option value="AC" {{ $unit->type == 'AC' ? 'selected' : '' }}>AC</option>
                            <option value="Non-AC" {{ $unit->type == 'Non-AC' ? 'selected' : '' }}>Non-AC</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Base Rent (₱)</label>
                        <input type="number" name="base_rent" value="{{ $unit->base_rent }}" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                            <option value="Vacant" {{ $unit->status == 'Vacant' ? 'selected' : '' }}>Vacant</option>
                            <option value="Occupied" {{ $unit->status == 'Occupied' ? 'selected' : '' }}>Occupied</option>
                            <option value="Maintenance" {{ $unit->status == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('units.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                        <button type="submit" class="bg-teal-700 hover:bg-teal-800 text-white font-bold py-2 px-6 rounded shadow-lg transition-colors">
                            Update Unit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
