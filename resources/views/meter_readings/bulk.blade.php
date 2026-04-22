<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Bulk Meter Reading Entry') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('meter_readings.bulk.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-6 flex justify-between items-center bg-teal-50 p-4 rounded-lg border border-teal-200">
                        <div>
                            <label class="block text-sm font-medium text-teal-900 font-bold">Reading Date for All Units:</label>
                            <input type="date" name="reading_date" value="{{ date('Y-m-d') }}" required class="mt-1 block rounded-md border-teal-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                        </div>
                        <div class="text-right text-teal-800 text-sm italic">
                            * Fill in the Current Reading for each room. System will subtract Previous automatically.
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-teal-800 text-white">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase">Unit</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase">Type</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase">Previous Reading</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase">Current Reading</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($units as $unit)
                                    <!-- Electricity Entry -->
                                    <tr class="hover:bg-gray-50 border-b">
                                        <td class="px-4 py-3 font-bold text-teal-900 bg-gray-50">Unit {{ $unit->unit_number }}</td>
                                        <td class="px-4 py-3 text-xs font-semibold text-yellow-700">Electricity</td>
                                        <td class="px-4 py-3">
                                            @php
                                                $lastElec = \App\Models\MeterReading::where('unit_id', $unit->id)->where('type', 'Electricity')->latest()->first();
                                            @endphp
                                            <input type="number" name="readings[{{ $unit->id }}][previous]" value="{{ $lastElec ? $lastElec->current_reading : 0 }}" step="0.01" readonly class="w-full bg-gray-100 border-none rounded text-sm text-gray-500">
                                            <input type="hidden" name="readings[{{ $unit->id }}][type]" value="Electricity">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="number" name="readings[{{ $unit->id }}][current]" step="0.01" placeholder="Enter Elect. Reading" class="w-full rounded border-teal-300 shadow-sm focus:ring-teal-500 text-sm">
                                        </td>
                                    </tr>
                                    <!-- Water Entry (Optional) -->
                                    <tr class="hover:bg-gray-50 border-b-2 border-gray-100">
                                        <td class="px-4 py-3 bg-gray-50"></td>
                                        <td class="px-4 py-3 text-xs font-semibold text-blue-700">Water</td>
                                        <td class="px-4 py-3">
                                            @php
                                                $lastWater = \App\Models\MeterReading::where('unit_id', $unit->id)->where('type', 'Water')->latest()->first();
                                            @endphp
                                            <input type="number" name="readings[{{ $unit->id }}_w][previous]" value="{{ $lastWater ? $lastWater->current_reading : 0 }}" step="0.01" readonly class="w-full bg-gray-100 border-none rounded text-sm text-gray-500">
                                            <input type="hidden" name="readings[{{ $unit->id }}_w][type]" value="Water">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="number" name="readings[{{ $unit->id }}_w][current]" step="0.01" placeholder="Enter Water Reading" class="w-full rounded border-teal-300 shadow-sm focus:ring-teal-500 text-sm">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-teal-700 hover:bg-teal-800 text-white font-bold py-3 px-12 rounded-lg shadow-xl transition-all transform hover:scale-105">
                            Submit All Readings & Calculate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
