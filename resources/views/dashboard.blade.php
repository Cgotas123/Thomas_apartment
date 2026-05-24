<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Thomas Apartment - Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if($stats['upcoming_dues']->count() > 0)
            <!-- UPCOMING DUES NOTIFICATION -->
            <div class="mb-8 bg-orange-100 border-l-4 border-orange-500 p-4 rounded-lg shadow-sm flex items-center gap-4 animate-pulse">
                <div class="text-3xl">⚠️</div>
                <div>
                    <h3 class="font-bold text-orange-800">Upcoming Payment Deadlines (Next 7 Days)</h3>
                    <p class="text-sm text-orange-700">There are {{ $stats['upcoming_dues']->count() }} tenants with bills due soon.</p>
                </div>
            </div>
            @endif

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Units -->
                <div class="bg-teal-700 overflow-hidden shadow-sm rounded-2xl p-6 text-white border-b-4 border-teal-900 transition-transform hover:scale-105">
                    <div class="text-sm font-black opacity-70 uppercase tracking-widest">Occupancy</div>
                    <div class="text-4xl font-black mt-2">{{ $stats['occupied_units'] }}/{{ $stats['total_units'] }}</div>
                    <div class="mt-4 text-[10px] font-bold bg-white/20 p-1 rounded inline-block">ROOMS FILLED</div>
                </div>

                <!-- Monthly Revenue -->
                <div class="bg-emerald-600 overflow-hidden shadow-sm rounded-2xl p-6 text-white border-b-4 border-emerald-800 transition-transform hover:scale-105">
                    <div class="text-sm font-black opacity-70 uppercase tracking-widest">Revenue (May)</div>
                    <div class="text-4xl font-black mt-2">₱{{ number_format($stats['monthly_revenue'], 0) }}</div>
                    <div class="mt-4 text-[10px] font-bold bg-white/20 p-1 rounded inline-block">COLLECTED SO FAR</div>
                </div>

                <!-- Active Tenants -->
                <div class="bg-blue-600 overflow-hidden shadow-sm rounded-2xl p-6 text-white border-b-4 border-blue-800 transition-transform hover:scale-105">
                    <div class="text-sm font-black opacity-70 uppercase tracking-widest">Active Tenants</div>
                    <div class="text-4xl font-black mt-2">{{ $stats['total_tenants'] }}</div>
                    <div class="mt-4 text-[10px] font-bold bg-white/20 p-1 rounded inline-block">TOTAL RESIDENTS</div>
                </div>

                <!-- Maintenance -->
                <div class="bg-orange-600 overflow-hidden shadow-sm rounded-2xl p-6 text-white border-b-4 border-orange-800 transition-transform hover:scale-105">
                    <div class="text-sm font-black opacity-70 uppercase tracking-widest">Repairs</div>
                    <div class="text-4xl font-black mt-2">{{ $stats['pending_maintenance'] }}</div>
                    <div class="mt-4 text-[10px] font-bold bg-white/20 p-1 rounded inline-block">PENDING TICKETS</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Upcoming Dues List -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b flex justify-between items-center">
                        <h3 class="text-xs font-black text-gray-800 uppercase tracking-widest">🔔 Upcoming Dues (Next 7 Days)</h3>
                    </div>
                    <div class="p-0 max-h-[400px] overflow-y-auto">
                        <table class="w-full">
                            <tbody class="divide-y divide-gray-100">
                                @forelse($stats['upcoming_dues'] as $bill)
                                <tr class="hover:bg-orange-50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $bill->lease->tenant->full_name }}</td>
                                    <td class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Room {{ $bill->lease->unit->unit_number }}</td>
                                    <td class="px-6 py-4 text-sm font-black text-emerald-600">₱{{ number_format($bill->total_amount, 2) }}</td>
                                    <td class="px-6 py-4 text-[10px] font-bold text-orange-600 uppercase">{{ $bill->due_date->format('M d') }} ({{ $bill->due_date->diffForHumans() }})</td>
                                </tr>
                                @empty
                                <tr><td class="p-8 text-center text-gray-400 italic">No upcoming dues found</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Delinquent Tenants -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b flex justify-between items-center">
                        <h3 class="text-xs font-black text-red-600 uppercase tracking-widest">⚠️ Not Paid (This Month)</h3>
                    </div>
                    <div class="p-0 max-h-[400px] overflow-y-auto">
                        <table class="w-full">
                            <tbody class="divide-y divide-gray-100">
                                @forelse($stats['delinquent_tenants'] as $lease)
                                <tr class="hover:bg-red-50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $lease->tenant->full_name }}</td>
                                    <td class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Room {{ $lease->unit->unit_number }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('tenants.sendMessage', $lease->tenant->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="subject" value="URGENT: Outstanding Payment for May">
                                            <input type="hidden" name="message" value="Hi {{ $lease->tenant->full_name }}, we noticed that you haven't recorded a payment for this month yet. Please settle your balance as soon as possible. Thank you!">
                                            <button type="submit" class="text-[10px] font-black bg-red-100 text-red-700 px-3 py-1 rounded-full hover:bg-red-700 hover:text-white transition-all uppercase">SEND REMINDER</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td class="p-8 text-center text-gray-400 italic text-sm">All tenants have paid for this month! 👏</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Payments Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-teal-900 text-white flex justify-between items-center">
                    <h3 class="text-xs font-black uppercase tracking-widest">Live Collection Stream</h3>
                    <a href="{{ route('payments.index') }}" class="text-[10px] font-black hover:underline uppercase">Full History →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-[9px] font-black text-gray-400 uppercase tracking-widest">Tenant & Room</th>
                                <th class="px-6 py-3 text-left text-[9px] font-black text-gray-400 uppercase tracking-widest">Amount</th>
                                <th class="px-6 py-3 text-left text-[9px] font-black text-gray-400 uppercase tracking-widest">Date</th>
                                <th class="px-6 py-3 text-left text-[9px] font-black text-gray-400 uppercase tracking-widest">Method</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($stats['recent_payments'] as $payment)
                            <tr class="hover:bg-teal-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-800">{{ $payment->lease->tenant->full_name }}</div>
                                    <div class="text-[10px] font-black text-gray-400 uppercase italic">Room {{ $payment->lease->unit->unit_number }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm font-black text-emerald-600">₱{{ number_format($payment->amount, 2) }}</td>
                                <td class="px-6 py-4 text-[10px] font-bold text-gray-500 uppercase">{{ $payment->payment_date }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-[9px] font-black rounded uppercase">{{ $payment->method }}</span>
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
