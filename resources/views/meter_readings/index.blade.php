<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Utility Meter Readings') }}
            </h2>
            <a href="{{ route('meter_readings.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded text-sm transition-colors">
                + Record New Reading
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-teal-800 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Unit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Reading (Prev → Curr)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Consumption</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Calculated Cost</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($readings as $reading)
                            <tr class="hover:bg-gray-50 transition-colors text-sm">
                                <td class="px-6 py-4 font-bold text-teal-900">Unit {{ $reading->unit->unit_number }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded text-xs font-bold {{ $reading->type == 'Electricity' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $reading->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $reading->previous_reading }} → {{ $reading->current_reading }}</td>
                                <td class="px-6 py-4 font-semibold">{{ $reading->consumption }} units</td>
                                <td class="px-6 py-4 text-emerald-700 font-extrabold">₱{{ number_format($reading->cost, 2) }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $reading->reading_date }}</td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('meter_readings.edit', $reading->id) }}" class="text-teal-600 hover:text-teal-900">Edit</a>
                                    <form action="{{ route('meter_readings.destroy', $reading->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this reading?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
