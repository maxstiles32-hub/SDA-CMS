<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Departments & Ministries') }}
            </h2>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-500">{{ $departments->count() }} departments total</span>
                <x-export-dropdown :routes="[
                    'csv' => route('departments.export', array_merge(request()->query(), ['format' => 'csv'])),
                    'pdf' => route('departments.export', array_merge(request()->query(), ['format' => 'pdf']))
                ]" />
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($departments->isEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <p class="text-gray-500 text-lg font-medium">No departments found.</p>
                    <p class="text-gray-400 text-sm mt-1">Departments will appear here once added to the system.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($departments as $department)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-md transition duration-200">
                            <!-- Department Icon & Header -->
                            <div class="flex items-start mb-4">
                                <div class="p-3 rounded-lg bg-indigo-100 text-indigo-600 mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-bold text-gray-900 leading-tight">{{ $department->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">
                                        {{ $department->description ?? 'No description provided.' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Member Count Badge -->
                            <div class="flex items-center mt-auto pt-4 border-t border-gray-100">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span class="font-semibold text-gray-800">{{ $department->members_count }}</span>
                                    <span class="ml-1 text-gray-500">{{ Str::plural('member', $department->members_count) }}</span>
                                </div>

                                <a href="{{ route('departments.show', $department) }}"
                                   class="ml-auto inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 transition">
                                    View Members
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
