<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Billing & Payments') }}
            </h2>
            
            <!-- Search Bar -->
            <div class="w-full md:w-1/2">
                <form action="{{ route('payments.index') }}" method="GET" class="flex">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Tenant, Unit, or Reference..." class="w-full rounded-l-md border-none focus:ring-teal-500 text-sm py-2">
                    <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 rounded-r-md transition-colors">
                        🔍
                    </button>
                </form>
            </div>

            <a href="{{ route('payments.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded text-sm transition-colors whitespace-nowrap">
                + Record New Payment
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
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tenant / Unit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Method</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($payments as $payment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $payment->lease->tenant->full_name }}</div>
                                    <div class="text-xs text-gray-500">Unit {{ $payment->lease->unit->unit_number }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-[10px] font-bold uppercase">{{ $payment->type }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-teal-700">₱{{ number_format($payment->amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 bg-emerald-50 text-emerald-700 rounded text-[10px] font-bold uppercase">{{ $payment->method }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->payment_date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-400 font-mono">{{ $payment->reference_no ?? '--' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                    <a href="{{ route('payments.edit', $payment->id) }}" class="text-teal-600 hover:text-teal-900">Edit</a>
                                    <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this payment record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                    {{ $payment->reference_no ?? '--' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
