<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center print:hidden">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center">
                <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ __('Financial Management') }}
            </h2>
            @if(auth()->user()->role === 'Treasurer' || auth()->user()->role === 'Super Admin')
                <div class="flex items-center gap-2">
                    <x-export-dropdown :routes="[
                        'csv' => route('finance.export', array_merge(request()->query(), ['format' => 'csv'])),
                        'pdf' => route('finance.export', array_merge(request()->query(), ['format' => 'pdf']))
                    ]" />
                    <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Print Report
                    </button>
                </div>
            @endif
        </div>
    </x-slot>

    <!-- Custom Print Styles -->
    <style>
        @media print {
            @page { size: A4; margin: 20mm; }
            body { background: white !important; color: black !important; }
            nav, header, footer, .print\:hidden { display: none !important; }
            .py-12 { padding-top: 0 !important; padding-bottom: 0 !important; background: transparent !important; }
            .bg-gray-50 { background-color: white !important; }
            .shadow-sm, .shadow-lg { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
            table { border-collapse: collapse !important; width: 100% !important; margin-bottom: 2rem !important; }
            th, td { border: 1px solid #e5e7eb !important; padding: 0.5rem !important; }
            th:last-child, td:last-child { display: none !important; }
        }
    </style>

    <div class="py-12 bg-gray-50 min-h-screen print:min-h-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Print Header block (Only visible during print) -->
            <div class="hidden print:block text-center border-b-2 border-gray-800 pb-6 mb-8 mt-4">
                <h1 class="text-3xl font-black uppercase tracking-wider text-gray-900">SDA Church</h1>
                <h2 class="text-xl font-semibold text-gray-600 mt-1">Financial Summary Report</h2>
                <p class="text-sm text-gray-500 mt-2">Generated on: {{ now()->format('F j, Y - h:i A') }}</p>
                <p class="text-sm text-gray-500">Prepared by: {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
            </div>

            @if (session('success'))
                <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded relative shadow-sm" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative shadow-sm" role="alert">
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
                <div class="bg-white rounded-xl shadow-sm border border-emerald-100 p-6 flex flex-col justify-center transform transition duration-300 hover:scale-105 hover:shadow-lg relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 opacity-10 text-emerald-600">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h2 class="font-bold text-emerald-600 text-sm uppercase tracking-wider mb-1">Total Income</h2>
                        <p class="text-4xl font-extrabold text-gray-900">GHS {{ number_format($totalIncome, 2) }}</p>
                    </div>
                </div>

                <!-- Total Expenses -->
                <div class="bg-white rounded-xl shadow-sm border border-red-100 p-6 flex flex-col justify-center transform transition duration-300 hover:scale-105 hover:shadow-lg relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 opacity-10 text-red-600">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h2 class="font-bold text-red-600 text-sm uppercase tracking-wider mb-1">Total Expenses</h2>
                        <p class="text-4xl font-extrabold text-gray-900">GHS {{ number_format($totalExpenses, 2) }}</p>
                    </div>
                </div>

                <!-- Net Balance -->
                <div class="bg-white rounded-xl shadow-sm border border-indigo-100 p-6 flex flex-col justify-center transform transition duration-300 hover:scale-105 hover:shadow-lg relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 opacity-10 text-indigo-600">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h2 class="font-bold text-indigo-600 text-sm uppercase tracking-wider mb-1">Net Balance</h2>
                        <p class="text-4xl font-extrabold text-gray-900 @if($netBalance < 0) text-red-600 @else text-emerald-600 @endif">GHS {{ number_format($netBalance, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 print:block">
                
                <!-- Left Column: Forms (Hidden on Print) -->
                <div class="lg:col-span-1 space-y-6 print:hidden">
                    
                    <!-- Record Tithe Form -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-lg border-b pb-2 mb-4 text-gray-800 flex items-center">
                            <span class="w-2 h-6 bg-emerald-500 rounded mr-2"></span>
                            Record Tithe
                        </h3>
                        <form method="POST" action="{{ route('finance.tithe.store') }}">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Member</label>
                                    <select name="member_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
                                        <option value="">Select Member</option>
                                        @foreach($members as $member)
                                            <option value="{{ $member->member_id }}">{{ $member->last_name }}, {{ $member->first_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Amount (GHS)</label>
                                        <input type="number" step="0.01" name="amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Date</label>
                                        <input type="date" name="date_received" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" required>
                                    </div>
                                </div>
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 transition">
                                    Save Tithe
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Record Expenditure Form -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-lg border-b pb-2 mb-4 text-gray-800 flex items-center">
                            <span class="w-2 h-6 bg-red-500 rounded mr-2"></span>
                            Record Expenditure
                        </h3>
                        <form method="POST" action="{{ route('finance.expenditure.store') }}">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Title / Purpose</label>
                                    <input type="text" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" placeholder="e.g. Utility Bill, Repair" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Category</label>
                                    <select name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm" required>
                                        @foreach($expenditureCategories as $cat)
                                            <option value="{{ $cat }}">{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Amount (GHS)</label>
                                        <input type="number" step="0.01" name="amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Date</label>
                                        <input type="date" name="expenditure_date" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" required>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                                    <select name="payment_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm" required>
                                        @foreach($paymentMethods as $method)
                                            <option value="{{ $method }}">{{ $method }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 transition">
                                    Save Expenditure
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Other Forms (Offering, Donation) combined/minimized for space -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-lg border-b pb-2 mb-4 text-gray-800">Other Finance Entries</h3>
                        <div x-data="{ activeTab: 'offering' }">
                            <div class="flex gap-2 mb-4">
                                <button @click="activeTab = 'offering'" :class="activeTab === 'offering' ? 'bg-teal-600 text-white' : 'bg-gray-100 text-gray-600'" class="px-3 py-1 text-xs font-bold rounded-full transition">Offering</button>
                                <button @click="activeTab = 'donation'" :class="activeTab === 'donation' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600'" class="px-3 py-1 text-xs font-bold rounded-full transition">Donation</button>
                            </div>

                            <div x-show="activeTab === 'offering'">
                                <form method="POST" action="{{ route('finance.offering.store') }}" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Offering Type</label>
                                        <select name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm" required>
                                            <option value="Divine Service">Divine Service</option>
                                            <option value="Sabbath School">Sabbath School</option>
                                            <option value="Camp Meeting">Camp Meeting</option>
                                            <option value="13th Sabbath">13th Sabbath</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <input type="number" step="0.01" name="amount" placeholder="Amount (GHS)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                        <input type="date" name="date_received" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                    </div>
                                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 transition">Save Offering</button>
                                </form>
                            </div>

                            <div x-show="activeTab === 'donation'">
                                <form method="POST" action="{{ route('finance.donation.store') }}" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Purpose</label>
                                        <input type="text" name="purpose" placeholder="e.g. Building Fund" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <input type="number" step="0.01" name="amount" placeholder="Amount (GHS)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                        <input type="date" name="date_received" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                    </div>
                                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition">Save Donation</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Recent Records Lists -->
                <div class="lg:col-span-2 space-y-6 print:mt-8">
                    
                    <!-- Integrated Finance History (Income + Expenditures) -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 print:p-0 print:border-none print:shadow-none break-inside-avoid shadow-lg transform transition hover:shadow-xl">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h3 class="text-lg font-extrabold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
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
                                                <button type="submit" class="text-red-600 hover:text-red-900"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="6" class="px-3 py-4 text-center text-sm text-gray-500 italic">No expenditures yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tithes List (Brief) -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 print:p-0 print:border-none print:shadow-none break-inside-avoid">
                        <h3 class="text-lg font-bold text-gray-800 border-b-2 border-emerald-200 pb-2 mb-4 flex items-center">
                            <span class="w-1 h-4 bg-emerald-500 mr-2"></span>
                            Recent Income (Tithes)
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Member</th>
                                        <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($tithes as $tithe)
                                    <tr class="hover:bg-emerald-50">
                                        <td class="px-3 py-2 text-sm text-gray-500">{{ $tithe->date_received->format('M d') }}</td>
                                        <td class="px-3 py-2 text-sm text-gray-900">{{ $tithe->member->first_name }} {{ $tithe->member->last_name }}</td>
                                        <td class="px-3 py-2 text-sm text-emerald-600 font-bold text-right">GHS {{ number_format($tithe->amount, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mini Aggregate View for Offerings/Donations -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h4 class="text-sm font-black text-teal-600 uppercase border-b pb-1 mb-2">Offerings</h4>
                            @foreach($offerings->take(5) as $off)
                                <div class="flex justify-between text-xs py-1">
                                    <span class="text-gray-500">{{ $off->date_received->format('M d') }} - {{ $off->category }}</span>
                                    <span class="font-bold text-gray-900">GHS {{ number_format($off->amount, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h4 class="text-sm font-black text-blue-600 uppercase border-b pb-1 mb-2">Donations</h4>
                            @foreach($donations->take(5) as $don)
                                <div class="flex justify-between text-xs py-1">
                                    <span class="text-gray-500">{{ $don->date_received->format('M d') }} - {{ Str::limit($don->purpose, 15) }}</span>
                                    <span class="font-bold text-gray-900">GHS {{ number_format($don->amount, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
