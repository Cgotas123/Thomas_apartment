<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Maintenance Requests') }}
            </h2>
            <a href="{{ route('maintenance.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded text-sm transition-colors">
                + New Request
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @forelse ($requests as $request)
                        <div class="mb-6 p-4 border rounded-lg bg-gray-50 flex flex-col md:flex-row justify-between items-start md:items-center">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="px-2 py-1 rounded text-xs font-bold uppercase tracking-wider
                                        {{ $request->priority == 'Urgent' ? 'bg-red-600 text-white' : ($request->priority == 'High' ? 'bg-orange-500 text-white' : 'bg-blue-500 text-white') }}">
                                        {{ $request->priority }}
                                    </span>
                                    <h3 class="text-lg font-bold text-teal-900">{{ $request->title }}</h3>
                                    <span class="text-xs text-gray-500 italic">Unit {{ $request->unit->unit_number }}</span>
                                </div>
                                <p class="text-gray-600 text-sm mb-2">{{ $request->description }}</p>
                                <div class="text-xs text-gray-400">
                                    Requested on: {{ $request->created_at->format('M d, Y h:i A') }}
                                </div>
                            </div>

                            <div class="mt-4 md:mt-0 md:ml-6 flex items-center gap-4">
                                <form action="{{ route('maintenance.update', $request->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="text-sm rounded border-gray-300 focus:border-teal-500 focus:ring focus:ring-teal-200">
                                        <option value="Pending" {{ $request->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="In Progress" {{ $request->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="Completed" {{ $request->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="Canceled" {{ $request->status == 'Canceled' ? 'selected' : '' }}>Canceled</option>
                                    </select>
                                </form>
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                    {{ $request->status == 'Completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $request->status }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 text-gray-500">
                            No maintenance requests found.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
