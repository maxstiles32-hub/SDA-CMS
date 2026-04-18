<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <div class="text-sm text-gray-500">Welcome, {{ auth()->user()?->first_name ?? 'Admin' }} ({{ auth()->user()?->role ?? 'Guest' }})</div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Statistics Cards Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Members Card -->
                <a href="{{ route('members.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center transform transition duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="font-semibold text-gray-500 text-sm">Total Members</h2>
                            <p class="text-3xl font-bold text-gray-800">{{ number_format($membersCount) }}</p>
                        </div>
                    </div>
                </a>

                <!-- Departments Card -->
                <a href="{{ route('departments.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center transform transition duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="font-semibold text-gray-500 text-sm">Departments</h2>
                            <p class="text-3xl font-bold text-gray-800">{{ number_format($departmentsCount) }}</p>
                        </div>
                    </div>
                </a>

                <!-- Baptisms Card -->
                <a href="{{ route('baptisms.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center transform transition duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-teal-100 text-teal-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="font-semibold text-gray-500 text-sm">Baptisms Record</h2>
                            <p class="text-3xl font-bold text-gray-800">{{ number_format($baptismsCount) }}</p>
                        </div>
                    </div>
                </a>

                <!-- Finance Card -->
                <a href="{{ route('finance.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center transform transition duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-emerald-100 text-emerald-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="font-semibold text-gray-500 text-sm">Financial Recs.</h2>
                            <p class="text-3xl font-bold text-gray-800">GHS {{ number_format($totalFinances, 2) }}</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Main Content Area -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
                <!-- Activity Log -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Recent Activities</h3>
                        <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View All &rarr;</a>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($activities as $activity)
                            <div class="py-3 flex items-center justify-between hover:bg-gray-50 rounded-lg px-2 transition">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 rounded-full bg-indigo-500 mr-3"></div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $activity->action }}</p>
                                        <p class="text-xs text-gray-500">{{ $activity->description }} &middot; By {{ optional($activity->user)->first_name ?? 'System' }}</p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400">{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <div class="text-center py-6 text-gray-500 text-sm italic">No recent system activities found.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Right Sidebar: Quick Actions & Charts -->
                <div class="space-y-6">
                    <!-- Gender Distribution Bar -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                        <h3 class="text-sm font-bold text-gray-800 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Gender Distribution
                        </h3>

                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-sm bg-blue-500"></span>
                                <span class="text-xs text-gray-600">Men</span>
                                <span class="text-xs font-bold text-blue-600">{{ $maleCount }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-sm bg-pink-500"></span>
                                <span class="text-xs text-gray-600">Women</span>
                                <span class="text-xs font-bold text-pink-600">{{ $femaleCount }}</span>
                            </div>
                        </div>

                        @php
                            $malePercent = $membersCount > 0 ? round(($maleCount / $membersCount) * 100, 1) : 0;
                            $femalePercent = $membersCount > 0 ? round(($femaleCount / $membersCount) * 100, 1) : 0;
                        @endphp
                        <div class="w-full h-5 rounded-md overflow-hidden flex shadow-inner border border-gray-100">
                            @if($maleCount > 0)
                                <div class="h-full flex items-center justify-center"
                                    style="width: {{ $malePercent }}%; background: linear-gradient(135deg, #3b82f6, #2563eb);">
                                    <span class="text-white text-[10px] font-bold">{{ $malePercent }}%</span>
                                </div>
                            @endif
                            @if($femaleCount > 0)
                                <div class="h-full flex items-center justify-center"
                                    style="width: {{ $femalePercent }}%; background: linear-gradient(135deg, #ec4899, #db2777);">
                                    <span class="text-white text-[10px] font-bold">{{ $femalePercent }}%</span>
                                </div>
                            @endif
                        </div>
                        @if($membersCount === 0)
                            <div class="w-full h-5 rounded-md bg-gray-100 flex items-center justify-center">
                                <span class="text-xs text-gray-400 italic">No members yet</span>
                            </div>
                        @endif
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
                        <div class="space-y-4">
                            <a href="{{ route('members.create') }}" class="group flex items-center p-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition">
                                <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Register New Member
                            </a>
                            @can('manage-finance')
                            <a href="{{ route('finance.index') }}" class="group flex items-center p-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Log Tithes & Offerings
                            </a>
                            @endcan
                            <a href="{{ route('documents.create') }}" class="group flex items-center p-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition">
                                <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Upload Document
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
