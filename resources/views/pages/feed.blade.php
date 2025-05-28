@extends('layout.app')

@section('content')

    <head>
        <title>FeedPost</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>

    <body class="bg-gray-100">
        <div class="container mx-auto py-8 px-4">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold">MoFeed</h1>
                <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    + Add post
                </a>
            </div>

            @foreach($posts as $post)
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
                    <p class="text-gray-500 text-sm mb-2">{{ $post->created_at->diffForHumans() }}</p>

                    @if($post->image)
                        <img src="{{ asset($post->image) }}" alt="{{ $post->title }}"
                            class="w-full h-64 object-cover rounded-lg mb-4">
                    @endif

                    <p class="text-gray-700 mb-4">{{ Str::limit($post->description, 200) }}</p>

                    <div class="flex items-center space-x-4 text-sm">
                        <form action="{{ route('posts.like', $post->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="flex items-center text-gray-600 hover:text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                Like ({{ $post->likes_count }})
                            </button>
                        </form>
                        
                        <div class="mt-4">
                            <form action="{{ route('posts.comment', $post->id) }}" method="POST">
                                @csrf
                                <div class="flex gap-2">
                                    <input type="text" name="comment" placeholder="Commenr..."
                                        class="flex-grow p-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                        Send
                                    </button>
                                </div>
                            </form>

                            <div class="mt-3 space-y-2">
                                @foreach($post->comments as $comment)
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <p class="text-gray-800">{{ $comment->comment }}</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </body>
@endsection
