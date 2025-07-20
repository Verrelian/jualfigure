<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $buyer->name }}'s Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
</head>
<body class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen">

    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-md shadow-lg sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <button onclick="history.back()" class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white hover:from-indigo-600 hover:to-purple-700 transition-all duration-300">
                    ←
                </button>
                <h1 class="text-xl font-bold text-gray-800">{{ $buyer->name }}'s Posts</h1>
            </div>
            <div class="flex items-center gap-3">
                <img src="{{ $buyer->avatar_url }}" class="w-8 h-8 rounded-full ring-2 ring-indigo-200" alt="{{ $buyer->username }}">
                <span class="text-sm text-gray-600">{{ '@' . $buyer->username }}</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 py-8">

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-fade-in">
            <div class="stat-card text-white p-6 rounded-2xl shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/80 text-sm">Total Posts</p>
                        <p class="text-3xl font-bold">{{ $stats['total_posts'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        📝
                    </div>
                </div>
            </div>

            <div class="stat-card text-white p-6 rounded-2xl shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/80 text-sm">Total Likes</p>
                        <p class="text-3xl font-bold">{{ $stats['total_likes'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        ❤️
                    </div>
                </div>
            </div>

            <div class="stat-card text-white p-6 rounded-2xl shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/80 text-sm">Total Comments</p>
                        <p class="text-3xl font-bold">{{ $stats['total_comments'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        💬
                    </div>
                </div>
            </div>
        </div>

        <!-- Posts Grid -->
        <div class="masonry-grid animate-slide-in">
            @forelse($posts as $post)
                @php
                    $imageUrls = $post->images->pluck('image')->map(fn($img) => asset('storage/' . $img));
                    $commentsData = $post->comments->map(fn($c) => [
                        'username' => $c->buyer->username ?? 'Unknown',
                        'buyer_avatar' => $c->buyer->avatar_url ?? '/images/default-avatar.png',
                        'comment' => $c->comment
                    ]);
                    $postPayload = [
                        'id' => $post->id,
                        'title' => $post->title,
                        'description' => $post->description,
                        'time' => $post->created_at->diffForHumans(),
                        'likes_count' => $post->likes_count,
                        'images' => $imageUrls,
                        'comments' => $commentsData
                    ];
                @endphp

                <div data-post='@json($postPayload)' class="masonry-item post-card bg-white rounded-2xl shadow-lg overflow-hidden cursor-pointer group">
                    @if($post->images->isNotEmpty())
                        <div class="relative">
                            <img src="{{ asset('storage/' . $post->images->first()->image) }}"
                                 class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300"
                                 alt="{{ $post->title }}">
                            <div class="post-overlay absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4 text-white">
                                <p class="text-sm font-medium">{{ $post->images->count() }} {{ Str::plural('image', $post->images->count()) }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-indigo-600 transition-colors">{{ $post->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">{{ Str::limit($post->description, 120) }}</p>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span class="flex items-center gap-1 text-red-500">❤️ {{ $post->likes_count }}</span>
                                <span class="flex items-center gap-1 text-blue-500">💬 {{ $post->comments->count() }}</span>
                            </div>
                            <span class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 col-span-full">
                    <div class="w-24 h-24 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">📝</div>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">No posts yet</h3>
                    <p class="text-gray-500">{{ $buyer->name }} hasn't shared any posts yet.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Include the working post modal component -->
    @include('component.posts.post-modal')

    <!-- SwiperJS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Init Post Modal Trigger -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-post]').forEach(div => {
                div.addEventListener('click', () => {
                    try {
                        const post = JSON.parse(div.dataset.post);
                        openPostModal(post);
                    } catch (e) {
                        console.error('Invalid post data:', e);
                    }
                });
            });

            // Animation for masonry cards
            const posts = document.querySelectorAll('.masonry-item');
            posts.forEach((post, i) => {
                post.style.animationDelay = `${i * 0.1}s`;
                post.classList.add('animate-fade-in');
            });
        });
    </script>

    <!-- Custom CSS -->
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .animate-fade-in { animation: fadeIn 0.6s ease-out; }
        .animate-slide-in { animation: slideIn 0.5s ease-out; }

        .post-card {
            transition: all 0.3s ease;
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.3);
        }

        .masonry-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .masonry-item {
            break-inside: avoid;
        }

        .post-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.1) 50%, transparent 100%);
        }
    </style>
</body>
</html>
