<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('New Tenant Registration') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('tenants.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="full_name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Emergency Contact (Name/Phone)</label>
                        <input type="text" name="emergency_contact" placeholder="e.g., Jane Doe - 09123456789" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Tenant Category</label>
                        <select name="category" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                            <option value="Student">Student</option>
                            <option value="Employee">Employee</option>
                            <option value="Family">Small Family</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end border-t pt-4">
                        <a href="{{ route('tenants.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Back to List</a>
                        <button type="submit" class="bg-teal-700 hover:bg-teal-800 text-white font-bold py-2 px-8 rounded shadow-lg transition-colors">
                            Complete Registration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
