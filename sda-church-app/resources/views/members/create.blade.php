<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Register New Member') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-8">

                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('members.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Profile Picture -->
                        <div class="md:col-span-2 flex items-center space-x-4 mb-4">
                            <div id="image-preview"
                                class="w-20 aspect-[3/4] rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden border-2 border-dashed border-gray-300">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label for="profile_picture" class="block font-medium text-sm text-gray-700">Member
                                    Profile Picture</label>
                                <input id="profile_picture" type="file" name="profile_picture"
                                    onchange="previewImage(event)"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                <p class="text-xs text-gray-400 mt-1">Recommended: Portrait image (3:4 ratio), max 2MB (JPG, PNG).</p>
                            </div>
                        </div>

                        <!-- First Name -->
                        <div>
                            <label for="first_name" class="block font-medium text-sm text-gray-700">First Name <span
                                    class="text-red-500">*</span></label>
                            <input id="first_name"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="text" name="first_name" value="{{ old('first_name') }}" required autofocus />
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label for="last_name" class="block font-medium text-sm text-gray-700">Last Name <span
                                    class="text-red-500">*</span></label>
                            <input id="last_name"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="text" name="last_name" value="{{ old('last_name') }}" required />
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="date_of_birth" class="block font-medium text-sm text-gray-700">Date of
                                Birth</label>
                            <input id="date_of_birth"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" />
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="gender" class="block font-medium text-sm text-gray-700">Gender <span
                                    class="text-red-500">*</span></label>
                            <select id="gender" name="gender"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block font-medium text-sm text-gray-700">Email Address <span
                                    class="text-red-500">*</span></label>
                            <input id="email"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="email" name="email" value="{{ old('email') }}" required />
                            <p class="text-xs text-gray-500 mt-1">Required for login account creation.</p>
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="contact_number" class="block font-medium text-sm text-gray-700">Phone
                                Number</label>
                            <input id="contact_number"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="text" name="contact_number" value="{{ old('contact_number') }}" />
                        </div>
                    </div>

                    <div class="mb-6">
                        <!-- Address -->
                        <label for="address" class="block font-medium text-sm text-gray-700">Home Address</label>
                        <textarea id="address"
                            class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            name="address" rows="3">{{ old('address') }}</textarea>
                    </div>

                    <hr class="mb-6 border-gray-200">

                    <h3 class="text-lg font-bold text-gray-800 mb-4">Church Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Membership Status -->
                        <div>
                            <label for="status" class="block font-medium text-sm text-gray-700">Status <span
                                    class="text-red-500">*</span></label>
                            <select id="status" name="status"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive
                                </option>
                                <option value="Transferred" {{ old('status') == 'Transferred' ? 'selected' : '' }}>
                                    Transferred</option>
                                <option value="Deceased" {{ old('status') == 'Deceased' ? 'selected' : '' }}>Deceased
                                </option>
                            </select>
                        </div>


                        <!-- Baptism Date -->
                        <div>
                            <label for="baptism_date" class="block font-medium text-sm text-gray-700">Baptism
                                Date</label>
                            <input id="baptism_date"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                type="date" name="baptism_date" value="{{ old('baptism_date') }}" />
                        </div>

                        <!-- Departments -->
                        <div class="md:col-span-3 mt-4">
                            <label for="departments" class="block font-medium text-sm text-gray-700">Assign to
                                Departments / Ministries (Hold Ctrl/Cmd to select multiple)</label>
                            <select id="departments" name="departments[]"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                multiple size="5">
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->department_id }}" {{ (collect(old('departments'))->contains($dept->department_id)) ? 'selected' : '' }}>
                                        {{ $dept->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Optional. Select the ministries this member actively
                                participates in.</p>
                        </div>
                    </div>

                    <hr class="mb-6 border-gray-200">

                    <h3 class="text-lg font-bold text-gray-800 mb-4">System Access (Account Generation)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Role Selection -->
                        <div>
                            <label for="role" class="block font-medium text-sm text-gray-700">System Role <span
                                    class="text-red-500">*</span></label>
                            <select id="role" name="role"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                @foreach($roles as $roleOption)
                                    <option value="{{ $roleOption }}" {{ old('role', 'Member') == $roleOption ? 'selected' : '' }}>
                                        {{ $roleOption }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Select the permission level for this user.</p>
                        </div>

                        <!-- Default Password -->
                        <div>
                            <label for="default_password" class="block font-medium text-sm text-gray-700">Default Password (Read Only)</label>
                            <input id="default_password"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 bg-gray-50 text-gray-600 focus:ring-0"
                                type="text" name="default_password" value="{{ $defaultPassword }}" readonly />
                            <p class="text-xs text-indigo-600 mt-1 font-medium">Please share this password with the member. They will be forced to change it on their first login.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('members.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-4">
                            Cancel
                        </a>
                        <x-primary-button class="ml-4 bg-indigo-600 hover:bg-indigo-700">
                            {{ __('Register Member') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('image-preview');
                output.innerHTML = `<img src="${reader.result}" class="w-full h-full object-cover">`;
                output.classList.remove('border-dashed', 'bg-gray-100');
                output.classList.add('border-solid', 'border-indigo-100');
            }
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
</x-app-layout>