<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Thomas Apartment - Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Units -->
                <div class="bg-teal-700 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white border-l-8 border-teal-900">
                    <div class="text-sm uppercase tracking-wider opacity-75">TOTAL UNITS</div>
                    <div class="text-3xl font-bold mt-1">{{ $stats['total_units'] }}</div>
                    <div class="mt-4 text-xs">21 units available across 3 floors</div>
                </div>

                <!-- Occupied -->
                <div class="bg-blue-700 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white border-l-8 border-blue-900">
                    <div class="text-sm uppercase tracking-wider opacity-75">OCCUPIED</div>
                    <div class="text-3xl font-bold mt-1">{{ $stats['occupied_units'] }}</div>
                    <div class="mt-4 text-xs">{{ $stats['vacant_units'] }} units currently vacant</div>
                </div>

                <!-- Maintenance -->
                <div class="bg-orange-600 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white border-l-8 border-orange-800">
                    <div class="text-sm uppercase tracking-wider opacity-75">PENDING REPAIRS</div>
                    <div class="text-3xl font-bold mt-1">{{ $stats['pending_maintenance'] }}</div>
                    <div class="mt-4 text-xs">Maintenance requests from tenants</div>
                </div>

                <!-- Revenue -->
                <div class="bg-emerald-700 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white border-l-8 border-emerald-900">
                    <div class="text-sm uppercase tracking-wider opacity-75">REVENUE (THIS MONTH)</div>
                    <div class="text-3xl font-bold mt-1">₱ {{ number_format($stats['monthly_revenue'], 2) }}</div>
                    <div class="mt-4 text-xs">Total rental and utility payments</div>
                </div>
            </div>

            <!-- Recent Payments -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-teal-900">Recent Payments</h3>
                    <a href="{{ route('payments.index') }}" class="text-teal-700 hover:text-teal-900 text-sm font-semibold">View All →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($stats['recent_payments'] as $payment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $payment->lease->tenant->full_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->lease->unit->unit_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-600">₱{{ number_format($payment->amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->payment_date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-[10px] font-bold uppercase">{{ $payment->method }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No recent payments found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
