<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Tenant Details: ') . $tenant->full_name }}
            </h2>
            <a href="{{ route('tenants.index') }}" class="text-sm bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition-colors">
                ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Basic Info -->
                    <div>
                        <h3 class="text-lg font-bold text-teal-800 border-b pb-2 mb-4">Profile Information</h3>
                        <div class="space-y-3">
                            <p><span class="text-gray-500 text-xs font-bold uppercase block">Full Name</span> <span class="text-lg font-bold">{{ $tenant->full_name }}</span></p>
                            <p><span class="text-gray-500 text-xs font-bold uppercase block">Category</span> <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded text-xs font-bold">{{ $tenant->category }}</span></p>
                            <p><span class="text-gray-500 text-xs font-bold uppercase block">Contact Number</span> <span class="font-bold text-gray-700">{{ $tenant->phone_number ?? 'N/A' }}</span></p>
                            <p><span class="text-gray-500 text-xs font-bold uppercase block">Email Address</span> <span class="text-gray-700 italic">{{ $tenant->email ?? 'N/A' }}</span></p>
                            <p><span class="text-gray-500 text-xs font-bold uppercase block">Registered Since</span> <span class="text-gray-700">{{ $tenant->registration_date }}</span></p>
                        </div>
                    </div>

                    <!-- Rental Info -->
                    <div class="bg-teal-50 p-6 rounded-xl border border-teal-100">
                        <h3 class="text-lg font-bold text-teal-900 mb-4 flex items-center gap-2">
                            🏠 Current Room & Lease
                        </h3>
                        @php $lease = $tenant->leases()->where('active', true)->first(); @endphp
                        @if($lease)
                            <div class="space-y-4">
                                <div class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm">
                                    <span class="text-sm font-bold text-gray-600">Unit Number</span>
                                    <span class="text-xl font-black text-teal-700">Unit {{ $lease->unit->unit_number }}</span>
                                </div>
                                <div class="flex justify-between items-center border-b pb-2">
                                    <span class="text-sm text-gray-600">Monthly Rent</span>
                                    <span class="font-bold text-emerald-600">₱{{ number_format($lease->monthly_rent, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center border-b pb-2">
                                    <span class="text-sm text-gray-600">Wi-Fi Fee</span>
                                    <span class="font-bold text-blue-600">₱{{ number_format($lease->wifi_fee, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center border-b pb-2 text-red-600">
                                    <span class="text-sm">Security Deposit</span>
                                    <span class="font-bold underline italic">₱{{ number_format($lease->security_deposit, 2) }}</span>
                                </div>
                            </div>
                        @else
                            <p class="text-red-500 text-center font-bold italic">No active lease found.</p>
                        @endif
                    </div>
                </div>

                <div class="mt-10 pt-6 border-t">
                    <h3 class="text-md font-bold text-gray-800 mb-4">📢 Emergency Contact</h3>
                    <div class="bg-red-50 p-4 rounded-lg border border-red-100 flex items-center gap-4">
                        <div class="text-2xl text-red-600">☎️</div>
                        <div class="text-lg font-bold text-red-900">{{ $tenant->emergency_contact ?? 'No Emergency Contact Listed' }}</div>
                    </div>
                </div>

                <div class="mt-10 flex gap-4">
                    <a href="{{ route('tenants.edit', $tenant->id) }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-6 rounded shadow-lg transition-all">Edit Profile / Change Room</a>
                    <form action="{{ route('tenants.destroy', $tenant->id) }}" method="POST" onsubmit="return confirm('Delete this tenant record? This will also vacate their room.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow-lg transition-all">Delete Tenant</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
