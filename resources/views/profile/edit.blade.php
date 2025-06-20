<x-app-layout>
    <div class="sm:ml-64">
        <div class="w-full max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-bread-crumb-navigation />

            <!-- Edit Profile Section -->
            <div class="p-4 sm:p-8 bg-white border border-gray-200 rounded-lg shadow-lg">

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="user_type" value="{{ $user->user_type }}">

                    <div class="mb-4">
                        <label class="block mb-2 font-bold">Name:</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-bold">Email:</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>

                    <!-- Common Profile Fields -->
                    <div class="mb-4">
                        <label class="block mb-2 font-bold">Phone:</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-bold">Address:</label>
                        <textarea name="address" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <!-- Show Student Fields -->
                    @if ($user->user_type == 'student')
                        <div class="mb-4">
                            <label class="block mb-2 font-bold">Department:</label>
                            <input type="text" name="department"
                                value="{{ old('department', $user->student->department ?? '') }}"
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-bold">Batch:</label>
                            <input type="text" name="batch" value="{{ old('batch', $user->student->batch ?? '') }}"
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>
                    @endif

                    <!-- Show Faculty Fields -->
                    @if ($user->user_type == 'faculty')
                        <div class="mb-4">
                            <label class="block mb-2 font-bold">Subject:</label>
                            <input type="text" name="subject"
                                value="{{ old('subject', $user->faculty->subject ?? '') }}"
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-bold">Experience (Years):</label>
                            <input type="number" name="experience"
                                value="{{ old('experience', $user->faculty->experience ?? '') }}"
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>
                    @endif

                    <!-- Show Driver Fields -->
                    @if ($user->user_type == 'driver')
                        <div class="mb-4">
                            <label class="block mb-2 font-bold">License Number:</label>
                            <input type="text" name="license_number"
                                value="{{ old('license_number', $user->driver->license_number ?? '') }}"
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-bold">Experience (Years):</label>
                            <input type="number" name="experience"
                                value="{{ old('experience', $user->driver->experience ?? '') }}"
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="w-full sm:w-auto px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                            Save Changes
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
