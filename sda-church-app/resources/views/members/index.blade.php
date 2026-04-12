<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Members Directory') }}
            </h2>
        <div class="flex items-center gap-4">
            <x-export-dropdown :routes="[
                'csv' => route('members.export', array_merge(request()->query(), ['format' => 'csv'])),
                'pdf' => route('members.export', array_merge(request()->query(), ['format' => 'pdf']))
            ]" />
            <a href="{{ route('members.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                + Register New Member
            </a>
        </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative shadow-sm" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6 mb-6 flex justify-between items-center">
                <form method="GET" action="{{ route('members.index') }}" class="flex w-full max-w-md">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search members by name, email, or contact number..." class="form-input rounded-l-md border-gray-300 w-full focus:ring-indigo-500 py-2 px-3 shadow-sm border focus:border-indigo-500">
                    <button type="submit" class="bg-indigo-50 px-4 py-2 rounded-r-md border border-l-0 border-gray-300 text-indigo-700 hover:bg-indigo-100 transition font-medium">Search</button>
                    @if($search)
                        <a href="{{ route('members.index') }}" class="ml-2 mt-2 text-sm text-gray-500 hover:text-gray-700">Clear</a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Info</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($members as $member)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap outline-none">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($member->profile_picture)
                                                    <img src="{{ asset('storage/' . $member->profile_picture) }}" alt="Profile" class="h-10 w-10 rounded-full object-cover border border-gray-200">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold uppercase">
                                                        {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $member->first_name }} {{ $member->last_name }}</div>
                                                <div class="text-sm text-gray-500">{{ $member->gender }} &middot; {{ $member->date_of_birth ? \Carbon\Carbon::parse($member->date_of_birth)->age . ' yrs' : 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $member->email ?? 'No Email' }}</div>
                                        <div class="text-sm text-gray-500">{{ $member->contact_number ?? 'No Phone' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($member->status === 'Active')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                        @elseif($member->status === 'Inactive')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Inactive</span>
                                        @elseif($member->status === 'Transferred')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Transferred</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ $member->status }}</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('members.show', $member->member_id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                        <a href="{{ route('members.edit', $member->member_id) }}" class="text-amber-600 hover:text-amber-900 mr-3">Edit</a>
                                        <form action="{{ route('members.destroy', $member->member_id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to remove this member?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 whitespace-nowrap text-sm text-gray-500 text-center italic">
                                        No members found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $members->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
