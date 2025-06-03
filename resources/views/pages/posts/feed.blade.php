@extends('layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Header Section -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10 backdrop-blur-sm bg-white/95">
        <div class="container mx-auto max-w-4xl px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-lg">R</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">R.Toys Feed</h1>
                        <p class="text-sm text-gray-500">Discover amazing content</p>
                    </div>
                </div>

                <!-- Create Post Button -->
                <button
                    onclick="document.getElementById('modal-create').classList.remove('hidden')"
                    class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-2.5 rounded-full font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Create Post</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Create Post (Hidden by default) -->
    <div id="modal-create" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 transform transition-all">
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Create New Post</h2>
                <button
                    onclick="document.getElementById('modal-create').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                @include('pages.posts.create')
            </div>
        </div>
    </div>

    <!-- Feed Content -->
    <div class="container mx-auto max-w-4xl px-4 py-8">
        @if($posts->count() > 0)
            <div class="space-y-8">
                @foreach($posts as $post)
                    <article class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                        <!-- Post Header -->
                        <div class="p-6 pb-4">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="relative">
                                    <img src="{{ asset('images/avatar.png') }}"
                                         class="h-12 w-12 rounded-full ring-2 ring-gray-100"
                                         alt="Avatar">
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white"></div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">R.Toys</h3>
                                    <p class="text-sm text-gray-500 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $post->created_at->diffForHumans() }}</span>
                                    </p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Post Content -->
                            <div class="mb-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-3 leading-tight">{{ $post->title }}</h2>
                                <p class="text-gray-600 leading-relaxed">{{ Str::limit($post->description, 300) }}</p>
                            </div>
                        </div>

                        <!-- Post Image -->
                        @if($post->image)
                            <div class="px-6 pb-6">
                                <div class="relative overflow-hidden rounded-xl bg-gray-100">
                                    <img src="{{ asset($post->image) }}"
                                         alt="{{ $post->title }}"
                                         class="w-full h-80 object-cover hover:scale-105 transition-transform duration-500" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>
                                </div>
                            </div>
                        @endif

                        <!-- Post Actions -->
                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-6">
                                    <!-- Like Button -->
                                    <form action="{{ route('posts.like', $post->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="flex items-center space-x-2 text-gray-600 hover:text-red-500 transition-colors group">
                                            <div class="p-2 rounded-full group-hover:bg-red-50 transition-colors">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                                </svg>
                                            </div>
                                            <span class="font-medium">{{ $post->likes_count }}</span>
                                        </button>
                                    </form>

                                    <!-- Fire Reaction -->
                                    <button class="flex items-center space-x-2 text-gray-600 hover:text-orange-500 transition-colors group">
                                        <div class="p-2 rounded-full group-hover:bg-orange-50 transition-colors">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M13.5.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14c0 4.42 3.58 8 8 8s8-3.58 8-8C20 8.61 17.41 3.8 13.5.67zM11.71 19c-1.78 0-3.22-1.4-3.22-3.14 0-1.62 1.05-2.76 2.81-3.12 1.77-.36 3.6-1.21 4.62-2.58.39 1.29.48 2.66.48 4.04.01 2.65-2.07 4.8-4.69 4.8z"/>
                                            </svg>
                                        </div>
                                        <span class="font-medium">2</span>
                                    </button>

                                    <!-- Comments Count -->
                                    <div class="flex items-center space-x-2 text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        <span class="font-medium">{{ $post->comments->count() }}</span>
                                    </div>
                                </div>

                                <!-- Share Button -->
                                <button class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Comment Form -->
                            <form action="{{ route('posts.comment', $post->id) }}" method="POST" class="mb-4">
                                @csrf
                                <div class="flex space-x-3">
                                    <img src="{{ asset('images/avatar.png') }}" class="h-8 w-8 rounded-full" alt="Your Avatar">
                                    <div class="flex-1 flex space-x-2">
                                        <input type="text"
                                               name="comment"
                                               placeholder="Write a thoughtful comment..."
                                               class="flex-1 px-4 py-2 bg-white border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                               required>
                                        <button type="submit"
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-full font-medium transition-colors flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                            </svg>
                                            <span class="hidden sm:inline">Send</span>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- Comments Section -->
                            @if($post->comments->count() > 0)
                                <div class="space-y-3 max-h-60 overflow-y-auto custom-scrollbar">
                                    @foreach($post->comments as $comment)
                                        <div class="flex space-x-3 group">
                                            <img src="{{ asset('images/avatar.png') }}" class="h-8 w-8 rounded-full flex-shrink-0" alt="Commenter Avatar">
                                            <div class="flex-1">
                                                <div class="bg-gray-100 rounded-2xl px-4 py-3 group-hover:bg-gray-150 transition-colors">
                                                    <p class="text-gray-800 text-sm leading-relaxed">{{ $comment->comment }}</p>
                                                </div>
                                                <div class="mt-1 flex items-center space-x-4 text-xs text-gray-400">
                                                    <span>{{ $comment->created_at->diffForHumans() }}</span>
                                                    <button class="hover:text-gray-600 transition-colors">Like</button>
                                                    <button class="hover:text-gray-600 transition-colors">Reply</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-10">
                <button class="bg-white hover:bg-gray-50 text-gray-700 font-medium py-3 px-8 rounded-full border border-gray-200 hover:border-gray-300 transition-all shadow-sm hover:shadow-md">
                    Load More Posts
                </button>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No posts yet</h3>
                <p class="text-gray-500 mb-8">Be the first to share something amazing with the community!</p>
                <button
                    onclick="document.getElementById('modal-create').classList.remove('hidden')"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-full font-medium transition-colors">
                    Create Your First Post
                </button>
            </div>
        @endif
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 2px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 2px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endsection