<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center print:hidden">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center">
                <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
                {{ __('Financial Management') }}
            </h2>
            @if(auth()->user()->role === 'Treasurer' || auth()->user()->role === 'Super Admin')
                    <div class="flex items-center gap-2">
                        <x-export-dropdown :routes="[
                    'csv' => route('finance.export', array_merge(request()->query(), ['format' => 'csv'])),
                    'pdf' => route('finance.export', array_merge(request()->query(), ['format' => 'pdf']))
                ]" />
                        <button onclick="window.print()"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                </path>
                            </svg>
                            Print Report
                        </button>
                    </div>
            @endif
        </div>
    </x-slot>

    <!-- Custom Print Styles -->
    <style>
        @media print {
            @page {
                size: A4;
                margin: 20mm;
            }

            body {
                background: white !important;
                color: black !important;
            }

            nav,
            header,
            footer,
            .print\:hidden {
                display: none !important;
            }

            .py-12 {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
                background: transparent !important;
            }

            .bg-gray-50 {
                background-color: white !important;
            }

            .shadow-sm,
            .shadow-lg {
                box-shadow: none !important;
                border: 1px solid #e5e7eb !important;
            }

            table {
                border-collapse: collapse !important;
                width: 100% !important;
                margin-bottom: 2rem !important;
            }

            th,
            td {
                border: 1px solid #e5e7eb !important;
                padding: 0.5rem !important;
            }

            th:last-child,
            td:last-child {
                display: none !important;
            }
        }
    </style>

    <div class="py-12 bg-gray-50 min-h-screen print:min-h-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Print Header block (Only visible during print) -->
            <div class="hidden print:block text-center border-b-2 border-gray-800 pb-6 mb-8 mt-4">
                <h1 class="text-3xl font-black uppercase tracking-wider text-gray-900">SDA Church</h1>
                <h2 class="text-xl font-semibold text-gray-600 mt-1">Financial Summary Report</h2>
                <p class="text-sm text-gray-500 mt-2">Generated on: {{ now()->format('F j, Y - h:i A') }}</p>
                <p class="text-sm text-gray-500">Prepared by: {{ auth()->user()->first_name }}
                    {{ auth()->user()->last_name }}
                </p>
            </div>

            @if (session('success'))
                <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded relative shadow-sm"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative shadow-sm"
                    role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <ul class="list-disc pl-5 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Finance Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Income -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-emerald-100 p-6 flex flex-col justify-center transform transition duration-300 hover:scale-105 hover:shadow-lg relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 opacity-10 text-emerald-600">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <h2 class="font-bold text-emerald-600 text-sm uppercase tracking-wider mb-1">Total Income</h2>
                        <p class="text-4xl font-extrabold text-gray-900">GHS {{ number_format($totalIncome, 2) }}</p>
                    </div>
                </div>

                <!-- Total Expenses -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-red-100 p-6 flex flex-col justify-center transform transition duration-300 hover:scale-105 hover:shadow-lg relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 opacity-10 text-red-600">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <h2 class="font-bold text-red-600 text-sm uppercase tracking-wider mb-1">Total Expenses</h2>
                        <p class="text-4xl font-extrabold text-gray-900">GHS {{ number_format($totalExpenses, 2) }}</p>
                    </div>
                </div>

                <!-- Net Balance -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-indigo-100 p-6 flex flex-col justify-center transform transition duration-300 hover:scale-105 hover:shadow-lg relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 opacity-10 text-indigo-600">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <h2 class="font-bold text-indigo-600 text-sm uppercase tracking-wider mb-1">Net Balance</h2>
                        <p
                            class="text-4xl font-extrabold text-gray-900 @if($netBalance < 0) text-red-600 @else text-emerald-600 @endif">
                            GHS {{ number_format($netBalance, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Unified Transaction Tab Navigation -->
            <div x-data="{ mainTab: 'tithe' }" class="space-y-6">

                <!-- Tab Bar -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 print:hidden">
                    <div class="flex flex-wrap gap-2">
                        <button type="button" @click="mainTab = 'tithe'"
                            :class="mainTab === 'tithe' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                            class="flex items-center gap-1.5 px-4 py-2 text-sm font-bold rounded-lg transition">
                            <span class="w-2 h-2 rounded-full bg-current opacity-75"></span>
                            Tithe
                        </button>
                        <button type="button" @click="mainTab = 'expenditure'"
                            :class="mainTab === 'expenditure' ? 'bg-red-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                            class="flex items-center gap-1.5 px-4 py-2 text-sm font-bold rounded-lg transition">
                            <span class="w-2 h-2 rounded-full bg-current opacity-75"></span>
                            Expenditure
                        </button>
                        <button type="button" @click="mainTab = 'offering'"
                            :class="mainTab === 'offering' ? 'bg-teal-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                            class="flex items-center gap-1.5 px-4 py-2 text-sm font-bold rounded-lg transition">
                            <span class="w-2 h-2 rounded-full bg-current opacity-75"></span>
                            Offering
                        </button>
                        <button type="button" @click="mainTab = 'donation'"
                            :class="mainTab === 'donation' ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                            class="flex items-center gap-1.5 px-4 py-2 text-sm font-bold rounded-lg transition">
                            <span class="w-2 h-2 rounded-full bg-current opacity-75"></span>
                            Donation
                        </button>
                    </div>
                </div>

                <!-- Main Grid: Form (left) + Matching Records (right) -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 print:block">

                    <!-- Left Column: Forms (Hidden on Print) -->
                    <div class="lg:col-span-1 print:hidden">

                        <!-- Tithe Form -->
                        <div x-show="mainTab === 'tithe'" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h3 class="font-bold text-lg border-b pb-2 mb-4 text-gray-800 flex items-center">
                                <span class="w-2 h-6 bg-emerald-500 rounded mr-2"></span>
                                Record Tithe
                            </h3>
                            <form method="POST" action="{{ route('finance.tithe.store') }}">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Member</label>
                                        <select name="member_id"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                                            required>
                                            <option value="">Select Member</option>
                                            @foreach($members as $member)
                                                <option value="{{ $member->member_id }}">{{ $member->last_name }},
                                                    {{ $member->first_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Amount (GHS)</label>
                                            <input type="number" step="0.01" name="amount"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm"
                                                required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Date</label>
                                            <input type="date" name="date_received" value="{{ date('Y-m-d') }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm"
                                                required>
                                        </div>
                                    </div>
                                    <button type="submit"
                                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 transition">
                                        Save Tithe
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Expenditure Form -->
                        <div x-show="mainTab === 'expenditure'" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h3 class="font-bold text-lg border-b pb-2 mb-4 text-gray-800 flex items-center">
                                <span class="w-2 h-6 bg-red-500 rounded mr-2"></span>
                                Record Expenditure
                            </h3>
                            <form method="POST" action="{{ route('finance.expenditure.store') }}">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Title / Purpose</label>
                                        <input type="text" name="title"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                            placeholder="e.g. Utility Bill, Repair" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Category</label>
                                        <select name="category"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm"
                                            required>
                                            @foreach($expenditureCategories as $cat)
                                                <option value="{{ $cat }}">{{ $cat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Amount (GHS)</label>
                                            <input type="number" step="0.01" name="amount"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                                required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Date</label>
                                            <input type="date" name="expenditure_date" value="{{ date('Y-m-d') }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                                required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                                        <select name="payment_method"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm"
                                            required>
                                            @foreach($paymentMethods as $method)
                                                <option value="{{ $method }}">{{ $method }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit"
                                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 transition">
                                        Save Expenditure
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Offering Form -->
                        <div x-show="mainTab === 'offering'" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h3 class="font-bold text-lg border-b pb-2 mb-4 text-gray-800 flex items-center">
                                <span class="w-2 h-6 bg-teal-500 rounded mr-2"></span>
                                Record Offering
                            </h3>
                            <form method="POST" action="{{ route('finance.offering.store') }}" class="space-y-4"
                                x-data="{
                                    mode: 'select',
                                    selectedCat: 'Divine Service',
                                    typedCat: '',
                                    get category() { return this.mode === 'select' ? this.selectedCat : this.typedCat; }
                                }">
                                @csrf
                                <input type="hidden" name="category" :value="category">
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <label class="block text-sm font-medium text-gray-700">Offering Type</label>
                                        <div class="flex gap-1">
                                            <button type="button" @click="mode = 'select'"
                                                :class="mode === 'select' ? 'bg-teal-600 text-white' : 'bg-gray-100 text-gray-600'"
                                                class="px-3 py-1 text-xs font-bold rounded-full transition">Select</button>
                                            <button type="button" @click="mode = 'write'"
                                                :class="mode === 'write' ? 'bg-teal-600 text-white' : 'bg-gray-100 text-gray-600'"
                                                class="px-3 py-1 text-xs font-bold rounded-full transition">Write</button>
                                        </div>
                                    </div>
                                    <div x-show="mode === 'select'">
                                        <select x-model="selectedCat"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                            <option value="Divine Service">Divine Service</option>
                                            <option value="Sabbath School">Sabbath School</option>
                                            <option value="Camp Meeting">Camp Meeting</option>
                                            <option value="13th Sabbath">13th Sabbath</option>
                                            @foreach($existingOfferingCategories as $cat)
                                                @if(!in_array($cat, ['Divine Service', 'Sabbath School', 'Camp Meeting', '13th Sabbath']))
                                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div x-show="mode === 'write'" x-cloak>
                                        <input type="text" x-model="typedCat"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                                            placeholder="e.g. Youth Offering, Special Collection...">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="number" step="0.01" name="amount" placeholder="Amount (GHS)"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                    <input type="date" name="date_received" value="{{ date('Y-m-d') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                </div>
                                <button type="submit"
                                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 transition">Save Offering</button>
                            </form>
                        </div>

                        <!-- Donation Form -->
                        <div x-show="mainTab === 'donation'" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h3 class="font-bold text-lg border-b pb-2 mb-4 text-gray-800 flex items-center">
                                <span class="w-2 h-6 bg-blue-500 rounded mr-2"></span>
                                Record Donation
                            </h3>
                            <form method="POST" action="{{ route('finance.donation.store') }}" class="space-y-4"
                                x-data="{
                                    mode: 'select',
                                    selectedPurpose: 'Building Fund',
                                    typedPurpose: '',
                                    get purpose() { return this.mode === 'select' ? this.selectedPurpose : this.typedPurpose; }
                                }">
                                @csrf
                                <input type="hidden" name="purpose" :value="purpose">
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <label class="block text-sm font-medium text-gray-700">Donation Purpose</label>
                                        <div class="flex gap-1">
                                            <button type="button" @click="mode = 'select'"
                                                :class="mode === 'select' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600'"
                                                class="px-3 py-1 text-xs font-bold rounded-full transition">Select</button>
                                            <button type="button" @click="mode = 'write'"
                                                :class="mode === 'write' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600'"
                                                class="px-3 py-1 text-xs font-bold rounded-full transition">Write</button>
                                        </div>
                                    </div>
                                    <div x-show="mode === 'select'">
                                        <select x-model="selectedPurpose"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                            <option value="Building Fund">Building Fund</option>
                                            <option value="Mission Work">Mission Work</option>
                                            <option value="Welfare & Charity">Welfare &amp; Charity</option>
                                            <option value="Youth Ministry">Youth Ministry</option>
                                            <option value="Music & Instruments">Music &amp; Instruments</option>
                                            @foreach($existingDonationPurposes as $purpose)
                                                @if(!in_array($purpose, ['Building Fund', 'Mission Work', 'Welfare & Charity', 'Youth Ministry', 'Music & Instruments']))
                                                    <option value="{{ $purpose }}">{{ $purpose }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div x-show="mode === 'write'" x-cloak>
                                        <input type="text" x-model="typedPurpose"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                                            placeholder="e.g. Hospital Bills, Disaster Relief...">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="number" step="0.01" name="amount" placeholder="Amount (GHS)"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                    <input type="date" name="date_received" value="{{ date('Y-m-d') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                </div>
                                <button type="submit"
                                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition">Save Donation</button>
                            </form>
                        </div>

                    </div>

                    <!-- Right Column: Records matching the active tab -->
                    <div class="lg:col-span-2 print:mt-8">

                        <!-- Recent Tithes -->
                        <div x-show="mainTab === 'tithe'"
                            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 print:p-0 print:border-none print:shadow-none break-inside-avoid">
                            <div class="flex justify-between items-center mb-4 border-b pb-2">
                                <h3 class="text-lg font-extrabold text-gray-800 flex items-center">
                                    <span class="w-1 h-5 bg-emerald-500 rounded mr-2"></span>
                                    Recent Tithes
                                </h3>
                                <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-1 rounded font-bold uppercase">Income</span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
                                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Member</th>
                                            <th class="px-3 py-2 text-right text-xs font-bold text-gray-500 uppercase">Amount</th>
                                            <th class="px-3 py-2 text-right text-xs font-bold text-gray-500 uppercase print:hidden">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse($tithes as $tithe)
                                            <tr class="hover:bg-emerald-50 transition border-l-4 border-transparent hover:border-emerald-500">
                                                <td class="px-3 py-2 text-sm text-gray-500">{{ $tithe->date_received->format('M d, Y') }}</td>
                                                <td class="px-3 py-2 text-sm text-gray-900 font-medium">{{ $tithe->member->first_name }} {{ $tithe->member->last_name }}</td>
                                                <td class="px-3 py-2 text-sm text-emerald-600 font-black text-right">GHS {{ number_format($tithe->amount, 2) }}</td>
                                                <td class="px-3 py-2 text-right text-sm font-medium print:hidden">
                                                    <form action="{{ route('finance.tithe.destroy', $tithe->tithe_id) }}" method="POST" onsubmit="return confirm('Delete this tithe record?');" class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-3 py-4 text-center text-sm text-gray-500 italic">No tithe records yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Recent Expenditures -->
                        <div x-show="mainTab === 'expenditure'"
                            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 print:p-0 print:border-none print:shadow-none break-inside-avoid">
                            <div class="flex justify-between items-center mb-4 border-b pb-2">
                                <h3 class="text-lg font-extrabold text-gray-800 flex items-center">
                                    <span class="w-1 h-5 bg-red-500 rounded mr-2"></span>
                                    Recent Expenditures
                                </h3>
                                <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded font-bold uppercase">Outflow</span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
                                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Title</th>
                                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Category</th>
                                            <th class="px-3 py-2 text-right text-xs font-bold text-gray-500 uppercase">Amount</th>
                                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Method</th>
                                            <th class="px-3 py-2 text-right text-xs font-bold text-gray-500 uppercase print:hidden">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse($expenditures as $exp)
                                            <tr class="hover:bg-red-50 transition border-l-4 border-transparent hover:border-red-500">
                                                <td class="px-3 py-2 text-sm text-gray-500">{{ $exp->expenditure_date->format('M d, Y') }}</td>
                                                <td class="px-3 py-2 text-sm text-gray-900 font-bold">{{ $exp->title }}</td>
                                                <td class="px-3 py-2 text-sm text-gray-600">{{ $exp->category }}</td>
                                                <td class="px-3 py-2 text-sm text-red-600 font-black text-right">(GHS {{ number_format($exp->amount, 2) }})</td>
                                                <td class="px-3 py-2 text-sm text-gray-500 uppercase tracking-tighter">{{ $exp->payment_method }}</td>
                                                <td class="px-3 py-2 text-right text-sm font-medium print:hidden">
                                                    <form action="{{ route('finance.expenditure.destroy', $exp->expenditure_id) }}" method="POST" onsubmit="return confirm('Delete this expenditure?');" class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="px-3 py-4 text-center text-sm text-gray-500 italic">No expenditures yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Recent Offerings -->
                        <div x-show="mainTab === 'offering'"
                            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 print:p-0 print:border-none print:shadow-none break-inside-avoid">
                            <div class="flex justify-between items-center mb-4 border-b pb-2">
                                <h3 class="text-lg font-extrabold text-gray-800 flex items-center">
                                    <span class="w-1 h-5 bg-teal-500 rounded mr-2"></span>
                                    Recent Offerings
                                </h3>
                                <span class="text-xs bg-teal-100 text-teal-700 px-2 py-1 rounded font-bold uppercase">Income</span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
                                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Category</th>
                                            <th class="px-3 py-2 text-right text-xs font-bold text-gray-500 uppercase">Amount</th>
                                            <th class="px-3 py-2 text-right text-xs font-bold text-gray-500 uppercase print:hidden">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse($offerings as $off)
                                            <tr class="hover:bg-teal-50 transition border-l-4 border-transparent hover:border-teal-500">
                                                <td class="px-3 py-2 text-sm text-gray-500">{{ $off->date_received->format('M d, Y') }}</td>
                                                <td class="px-3 py-2 text-sm text-gray-900 font-medium">{{ $off->category }}</td>
                                                <td class="px-3 py-2 text-sm text-teal-600 font-black text-right">GHS {{ number_format($off->amount, 2) }}</td>
                                                <td class="px-3 py-2 text-right text-sm font-medium print:hidden">
                                                    <form action="{{ route('finance.offering.destroy', $off->offering_id) }}" method="POST" onsubmit="return confirm('Delete this offering?');" class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-3 py-4 text-center text-sm text-gray-500 italic">No offering records yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Recent Donations -->
                        <div x-show="mainTab === 'donation'"
                            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 print:p-0 print:border-none print:shadow-none break-inside-avoid">
                            <div class="flex justify-between items-center mb-4 border-b pb-2">
                                <h3 class="text-lg font-extrabold text-gray-800 flex items-center">
                                    <span class="w-1 h-5 bg-blue-500 rounded mr-2"></span>
                                    Recent Donations
                                </h3>
                                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded font-bold uppercase">Income</span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
                                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Member</th>
                                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Purpose</th>
                                            <th class="px-3 py-2 text-right text-xs font-bold text-gray-500 uppercase">Amount</th>
                                            <th class="px-3 py-2 text-right text-xs font-bold text-gray-500 uppercase print:hidden">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse($donations as $don)
                                            <tr class="hover:bg-blue-50 transition border-l-4 border-transparent hover:border-blue-500">
                                                <td class="px-3 py-2 text-sm text-gray-500">{{ $don->date_received->format('M d, Y') }}</td>
                                                <td class="px-3 py-2 text-sm text-gray-900 font-medium">{{ $don->member->first_name ?? '—' }} {{ $don->member->last_name ?? '' }}</td>
                                                <td class="px-3 py-2 text-sm text-gray-600">{{ $don->purpose }}</td>
                                                <td class="px-3 py-2 text-sm text-blue-600 font-black text-right">GHS {{ number_format($don->amount, 2) }}</td>
                                                <td class="px-3 py-2 text-right text-sm font-medium print:hidden">
                                                    <form action="{{ route('finance.donation.destroy', $don->donation_id) }}" method="POST" onsubmit="return confirm('Delete this donation?');" class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-3 py-4 text-center text-sm text-gray-500 italic">No donation records yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Funds Controller Records (always visible below) -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 print:p-0 print:border-none print:shadow-none break-inside-avoid">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg font-extrabold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Funds Controller Records
                        </h3>
                        <div class="flex gap-2">
                            <span class="text-xs bg-purple-100 text-purple-600 px-2 py-1 rounded font-bold">
                                Dept: GHS {{ number_format($totalDeptFunds, 2) }}
                            </span>
                            <span class="text-xs bg-amber-100 text-amber-600 px-2 py-1 rounded font-bold">
                                Class: GHS {{ number_format($totalClassFunds, 2) }}
                            </span>
                        </div>
                    </div>

                    <div x-data="{ fundsTab: 'departments' }">
                        <div class="flex gap-2 mb-4">
                            <button type="button" @click="fundsTab = 'departments'"
                                :class="fundsTab === 'departments' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-600'"
                                class="px-3 py-1 text-xs font-bold rounded-full transition">Departments</button>
                            <button type="button" @click="fundsTab = 'classes'"
                                :class="fundsTab === 'classes' ? 'bg-amber-600 text-white' : 'bg-gray-100 text-gray-600'"
                                class="px-3 py-1 text-xs font-bold rounded-full transition">Classes</button>
                        </div>

                        <!-- Department Funds Tab -->
                        <div x-show="fundsTab === 'departments'">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
                                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Department</th>
                                            <th class="px-3 py-2 text-right text-xs font-bold text-gray-500 uppercase">Amount</th>
                                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Receipt #</th>
                                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Recorded By</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse($departmentFunds as $df)
                                            <tr class="hover:bg-purple-50 transition border-l-4 border-transparent hover:border-purple-500">
                                                <td class="px-3 py-2 text-sm text-gray-500">{{ $df->date_received->format('M d, Y') }}</td>
                                                <td class="px-3 py-2 text-sm text-gray-900 font-bold">{{ $df->department->name ?? 'Unknown' }}</td>
                                                <td class="px-3 py-2 text-sm text-purple-600 font-black text-right">GHS {{ number_format($df->amount, 2) }}</td>
                                                <td class="px-3 py-2 text-xs text-gray-400 font-mono">{{ $df->receipt_number }}</td>
                                                <td class="px-3 py-2 text-sm text-gray-500">{{ $df->recordedBy->first_name ?? '' }} {{ $df->recordedBy->last_name ?? '' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-3 py-4 text-center text-sm text-gray-500 italic">No department fund records yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Class Funds Tab -->
                        <div x-show="fundsTab === 'classes'" x-cloak>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
                                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Class Name</th>
                                            <th class="px-3 py-2 text-right text-xs font-bold text-gray-500 uppercase">Amount</th>
                                            <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Receipt #</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse($classFunds as $cf)
                                            <tr class="hover:bg-amber-50 transition border-l-4 border-transparent hover:border-amber-500">
                                                <td class="px-3 py-2 text-sm text-gray-500">{{ $cf->date_received->format('M d, Y') }}</td>
                                                <td class="px-3 py-2 text-sm text-gray-900 font-bold">{{ $cf->class_name }}</td>
                                                <td class="px-3 py-2 text-sm text-amber-600 font-black text-right">GHS {{ number_format($cf->amount, 2) }}</td>
                                                <td class="px-3 py-2 text-xs text-gray-400 font-mono">{{ $cf->receipt_number }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-3 py-4 text-center text-sm text-gray-500 italic">No class fund records yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>