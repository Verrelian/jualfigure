@extends('layout.app')

@section('content')
    <div class="container mx-auto p-4">
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
                {{-- Pastikan file ini ada di resources/views/pages/posts/create.blade.php --}}
                @include('pages.posts.create')
            </div>
        </div>
    </div>

    <div class="container mx-auto max-w-4xl px-4 py-8">
        {{-- Success/Error Messages (opsional, bisa ditempatkan di layout utama) --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if (session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Info!</strong>
                <span class="block sm:inline">{{ session('info') }}</span>
            </div>
        @endif

        @if($posts->count() > 0)
            <div class="space-y-8">
                @foreach($posts as $post)
                    <article class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                        <div class="p-6 pb-4">
                            <div class="flex items-center space-x-3 mb-4">
                                {{-- Link ke profil pengguna --}}
                                <a href="{{ route('profile.show', $post->buyer->buyer_id) }}" class="flex items-center space-x-3">
                                <div class="relative">
                                    {{-- Menggunakan accessor avatar_url dari model Buyer --}}
                                    <img src="{{ $post->buyer->avatar_url }}"
                                         class="h-12 w-12 rounded-full ring-2 ring-gray-100"
                                         alt="{{ $post->buyer->username ?? 'Unknown' }} Avatar">
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white"></div>
                                </div>
                                <div class="flex-1">
                                    {{-- Menampilkan username buyer --}}
                                    <h3 class="font-semibold text-gray-900">{{ $post->buyer->username ?? 'Unknown User' }}</h3>
                                    <p class="text-sm text-gray-500 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $post->created_at->diffForHumans() }}</span>
                                    </p>
                                </div>
                                </a>
                                {{-- Tombol ini (3 titik) tidak terkait fungsionalitas, biarkan saja --}}
                                <div class="flex items-center space-x-2">
                                    <button class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-3 leading-tight">{{ $post->title }}</h2>
                                <p class="text-gray-600 leading-relaxed">{{ Str::limit($post->description, 300) }}</p>
                            </div>
                        </div>

                        @if($post->image)
                            <div class="px-6 pb-6">
                                <div class="relative overflow-hidden rounded-xl bg-gray-100">
                                    {{-- Menggunakan accessor getImageUrlAttribute() dari model Post --}}
                                    <img src="{{ $post->image_url }}"
                                         alt="{{ $post->title }}"
                                         class="w-full h-80 object-cover hover:scale-105 transition-transform duration-500" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>
                                </div>
                            </div>
                        @endif

                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-6">
                                    {{-- Form untuk like/unlike postingan --}}
                                   <form action="{{ route('posts.like', ['post' => $post->id]) }}" method="POST" class="inline"> {{-- PERBAIKAN: Gunakan $post->id --}}

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

                                    <div class="flex items-center space-x-2 text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        {{-- Menggunakan comments_count dari withCount() di controller --}}
                                        <span class="font-medium">{{ $post->comments_count }}</span>
                                    </div>
                                </div>

                                <button class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                    </svg>
                                </button>
                            </div>

                            {{-- Form komentar --}}
                            <form action="{{ route('posts.comment', $post->id) }}" method="POST" class="mb-4"> {{-- PERBAIKAN: Gunakan $post->id --}}
                                @csrf
                                <div class="flex space-x-3">
                                    {{-- Menggunakan avatar user yang sedang login dari session --}}
                                    <img src="{{ session('buyer_avatar_url') }}" class="h-8 w-8 rounded-full" alt="Your Avatar">
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
                                @error('comment') {{-- Menampilkan error validasi komentar --}}
                                    <p class="text-red-500 text-sm mt-1 ml-14">{{ $message }}</p>
                                @enderror
                            </form>

                            @if($post->comments->count() > 0)
                                <div class="space-y-3 max-h-60 overflow-y-auto custom-scrollbar">
                                    @foreach($post->comments as $comment)
                                        <div class="flex space-x-3 group">
                                            {{-- Menggunakan avatar commenter dari relasi buyer --}}
                                            <img src="{{ $comment->buyer->avatar_url }}" class="h-8 w-8 rounded-full flex-shrink-0" alt="Commenter Avatar">
                                            <div class="flex-1">
                                                <div class="bg-gray-100 rounded-2xl px-4 py-3 group-hover:bg-gray-150 transition-colors">
                                                    {{-- Menampilkan nama commenter --}}
                                                    <p class="font-semibold text-gray-900 text-sm mb-1">{{ $comment->buyer->username ?? 'Unknown Commenter' }}</p>
                                                    <p class="text-gray-800 text-sm leading-relaxed">{{ $comment->comment }}</p>
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

            <div class="text-center mt-10">
                <button class="bg-white hover:bg-gray-50 text-gray-700 font-medium py-3 px-8 rounded-full border border-gray-200 hover:border-gray-300 transition-all shadow-sm hover:shadow-md">
                    Load More Posts
                </button>
            </div>
        @else
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
