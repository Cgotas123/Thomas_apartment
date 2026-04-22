<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit Meter Reading') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('meter_readings.update', $meterReading->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Unit</label>
                            <select name="unit_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}" {{ $meterReading->unit_id == $unit->id ? 'selected' : '' }}>Unit {{ $unit->unit_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Utility Type</label>
                            <select name="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                                <option value="Electricity" {{ $meterReading->type == 'Electricity' ? 'selected' : '' }}>Electricity (₱15/kWh)</option>
                                <option value="Water" {{ $meterReading->type == 'Water' ? 'selected' : '' }}>Water (₱50/unit)</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Previous Reading</label>
                            <input type="number" name="previous_reading" value="{{ $meterReading->previous_reading }}" step="0.01" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Current Reading</label>
                            <input type="number" name="current_reading" value="{{ $meterReading->current_reading }}" step="0.01" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Reading Date</label>
                        <input type="date" name="reading_date" value="{{ $meterReading->reading_date }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                    </div>

                    <div class="flex items-center justify-end border-t pt-4">
                        <a href="{{ route('meter_readings.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                        <button type="submit" class="bg-teal-700 hover:bg-teal-800 text-white font-bold py-2 px-8 rounded shadow-lg transition-colors">
                            Update Reading
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
