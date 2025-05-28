@extends('layout.app')

@section('content')
<div class="bg-white min-h-screen py-10 px-4">
    <div class="container mx-auto max-w-5xl">
        @foreach($posts as $post)
            <div class="bg-white rounded-xl shadow-sm border mb-6 overflow-hidden">
                <div class="flex flex-col md:flex-row">

                    {{-- Kiri: Info Post --}}
                    <div class="p-6 flex-1">
                        <div class="flex items-center space-x-3 mb-3">
                            <img src="{{ asset('images/avatar.png') }}" class="h-8 w-8 rounded-full" alt="Avatar">
                            <div class="text-sm text-gray-500">
                                <strong>R.Toys</strong> • {{ $post->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <h2 class="text-xl font-bold mb-2">{{ $post->title }}</h2>
                        <p class="text-gray-600 mb-4">{{ Str::limit($post->description, 200) }}</p>

                        {{-- Like & Reaksi --}}
                        <div class="flex items-center space-x-3 text-sm text-gray-600 mb-4">
                            <form action="{{ route('posts.like', $post->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center hover:text-red-500">
                                    ❤️ {{ $post->likes_count }}
                                </button>
                            </form>
                            <span>🔥 2</span>
                        </div>

                        {{-- Kolom Komentar --}}
                        <form action="{{ route('posts.comment', $post->id) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="flex gap-2">
                                <input type="text" name="comment" placeholder="Write a comment..."
                                    class="flex-grow p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" required>
                                <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                    Send
                                </button>
                            </div>
                        </form>

                        {{-- Komentar ditampilkan --}}
                        <div class="space-y-2 max-h-32 overflow-y-auto">
                            @foreach($post->comments as $comment)
                                <div class="bg-gray-50 p-2 rounded-lg">
                                    <p class="text-gray-800 text-sm">{{ $comment->comment }}</p>
                                    <p class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Kanan: Gambar --}}
                    @if($post->image)
                        <div class="md:w-1/3 h-60 overflow-hidden">
                            <img src="{{ asset($post->image) }}" alt="{{ $post->title }}"
                                class="w-full h-full object-cover rounded-r-lg" />
                        </div>

                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
