@extends('layouts.app')

@section('content')
<div class="bg-gray-300 min-h-screen py-6">
    <div class="max-w-lg mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">

            <!-- Header -->
            <div class="bg-black text-white p-3">
                <div class="flex justify-start items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </div>
            </div>

            <div class="p-4">
                <h2 class="text-xl font-bold mb-4 text-center">Edit Profile</h2>

                <div class="flex flex-wrap">
                    <!-- Profile Image -->
                    <div class="w-1/4 pr-4 flex flex-col items-center">
                        <div class="w-20 h-20 rounded-full overflow-hidden mb-2">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://via.placeholder.com/150/FF5733/FFFFFF?text=LH" alt="Profile" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <label for="avatar-upload" class="bg-gray-200 text-gray-800 rounded px-2 py-1 text-xs cursor-pointer">Upload Photo</label>
                        <input id="avatar-upload" type="file" name="avatar" class="hidden" form="profile-form">
                    </div>

                    <!-- Form -->
                    <div class="w-3/4">
                        <form id="profile-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Username & Email -->
                            <div class="flex mb-3 space-x-3">
                                <div class="w-1/2">
                                    <label for="username" class="block text-gray-600 text-xs mb-1">Username:</label>
                                    <input type="text" id="username" name="username" class="w-full border border-gray-300 rounded p-1.5 text-sm @error('username') border-red-500 @enderror" value="{{ old('username', $user->username) }}">
                                    @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="w-1/2">
                                    <label for="email" class="block text-gray-600 text-xs mb-1">Email:</label>
                                    <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded p-1.5 text-sm @error('email') border-red-500 @enderror" value="{{ old('email', $user->email) }}">
                                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <!-- Name, Nickname, Country -->
                            <div class="flex mb-3 space-x-3">
                                <div class="w-1/3">
                                    <label for="name" class="block text-gray-600 text-xs mb-1">Name:</label>
                                    <input type="text" id="name" name="name" class="w-full border border-gray-300 rounded p-1.5 text-sm @error('name') border-red-500 @enderror" value="{{ old('name', $user->name) }}">
                                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="w-1/3">
                                    <label for="nickname" class="block text-gray-600 text-xs mb-1">Nickname:</label>
                                    <input type="text" id="nickname" name="nickname" class="w-full border border-gray-300 rounded p-1.5 text-sm @error('nickname') border-red-500 @enderror" value="{{ old('nickname', $user->nickname) }}">
                                    @error('nickname') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="w-1/3">
                                    <label for="country" class="block text-gray-600 text-xs mb-1">Country:</label>
                                    <select id="country" name="country" class="w-full border border-gray-300 rounded p-1.5 text-sm bg-white @error('country') border-red-500 @enderror">
                                        @foreach($countries as $code => $country)
                                            <option value="{{ $code }}" {{ old('country', $user->country) == $code ? 'selected' : '' }}>{{ $country }}</option>
                                        @endforeach
                                    </select>
                                    @error('country') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <!-- Bio -->
                            <div class="mb-3">
                                <label for="bio" class="block text-gray-600 text-xs mb-1">Bio:</label>
                                <textarea id="bio" name="bio" class="w-full border border-gray-300 rounded p-2 text-sm h-24 @error('bio') border-red-500 @enderror">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Birthdate, Phone, Address -->
                            <div class="flex mb-3 space-x-3">
                                <div class="w-1/3">
                                    <label for="birthdate" class="block text-gray-600 text-xs mb-1">Birthdate:</label>
                                    <input type="date" id="birthdate" name="birthdate" class="w-full border border-gray-300 rounded p-1.5 text-sm @error('birthdate') border-red-500 @enderror" value="{{ old('birthdate', $user->birthdate) }}">
                                    @error('birthdate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="w-1/3">
                                    <label for="phone" class="block text-gray-600 text-xs mb-1">Phone:</label>
                                    <input type="text" id="phone" name="phone" class="w-full border border-gray-300 rounded p-1.5 text-sm @error('phone') border-red-500 @enderror" value="{{ old('phone', $user->phone) }}">
                                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="w-1/3">
                                    <label for="address" class="block text-gray-600 text-xs mb-1">Address:</label>
                                    <input type="text" id="address" name="address" class="w-full border border-gray-300 rounded p-1.5 text-sm @error('address') border-red-500 @enderror" value="{{ old('address', $user->address) }}">
                                    @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <!-- Save -->
                            <div class="flex justify-end">
                                <button type="submit" class="bg-black text-white rounded px-4 py-1 text-sm">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection