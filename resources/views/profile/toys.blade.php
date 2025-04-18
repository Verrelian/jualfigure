{{-- resources/views/profile/toys.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto my-4">
    <!-- Profile Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header with Menu -->
        <div class="bg-black text-white p-3">
            <div class="flex justify-start items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </div>
        </div>
        
        <!-- Profile Content -->
        <div class="flex">
            <!-- Left side (Profile info & toys) -->
            <div class="w-2/3 p-4">
                <div class="flex items-center mb-3">
                    <h2 class="text-xl font-bold">{{ $user->name }}</h2>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                    </svg>
                </div>
                
                <!-- Tabs -->
                <div class="flex space-x-4 mb-4">
                    <a href="{{ route('profile.posts', $user) }}" 
                       class="px-4 py-1 bg-gray-200 rounded-md text-sm font-medium {{ request()->routeIs('profile.posts') ? 'text-blue-500 border-b-2 border-blue-500' : '' }}">
                        Posts
                    </a>
                    <a href="{{ route('profile.toys', $user) }}" 
                       class="px-4 py-1 bg-gray-200 rounded-md text-sm font-medium {{ request()->routeIs('profile.toys') ? 'text-blue-500 border-b-2 border-blue-500' : '' }}">
                        Toys
                    </a>
                </div>
                
                <!-- Toys Collection -->
                <div class="grid grid-cols-5 gap-3 mb-6">
                    @foreach($toys as $toy)
                    <div class="flex flex-col items-center">
                        <div class="bg-{{ $toy->color }}-100 rounded-md p-2 w-full flex justify-center mb-1">
                            <div class="w-8 h-10 bg-{{ $toy->color }}-600"></div>
                        </div>
                        <span class="text-xs text-gray-500">{{ $toy->name }}</span>
                    </div>
                    @endforeach
                </div>
                
                <!-- Action Buttons -->
                <div class="flex space-x-2">
                    <a href="{{ route('profile.posts', $user) }}" class="bg-black text-white rounded-full px-6 py-2 text-sm font-medium text-center">View Post</a>
                    <a href="{{ route('profile.toys', $user) }}" class="bg-gray-200 text-black rounded-full px-6 py-2 text-sm font-medium text-center">View Toys</a>
                </div>
            </div>
            
            <!-- Right side (User info) -->
            <div class="w-1/3 p-4 bg-gray-50">
                <div class="flex flex-col items-center">
                    <!-- Profile Image -->
                    <div class="w-16 h-16 rounded-full overflow-hidden mb-2">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://via.placeholder.com/150/FF5733/FFFFFF?text=LH" alt="Profile" class="w-full h-full object-cover">
                        @endif
                    </div>
                    
                    <!-- User Info -->
                    <div class="text-center">
                        <h3 class="font-bold">{{ $user->nickname ?? 'Loyal Hunter' }}</h3>
                        <p class="text-sm text-gray-600">{{ $user->name }}</p>
                        
                        <!-- Counts -->
                        <div class="flex justify-center space-x-6 my-2 text-xs">
                            <div>
                                <p class="text-gray-500">Followers</p>
                                <p class="font-bold">{{ number_format($user->followers_count) }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Following</p>
                                <p class="font-bold">{{ number_format($user->following_count) }}</p>
                            </div>
                        </div>
                        
                        <!-- Edit Profile Button -->
                        @if(auth()->id() === $user->id)
                            <a href="{{ route('profile.edit') }}" class="bg-black text-white rounded-lg w-full py-1 text-sm mt-2 block text-center">Edit Profile</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection