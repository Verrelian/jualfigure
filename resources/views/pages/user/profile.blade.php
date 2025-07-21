<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ $user->name }} - Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        }

        .stat-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #475569;
            border: 1px solid #e2e8f0;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .toy-item {
            transition: all 0.3s ease;
        }

        .toy-item:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

</div>

    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-sm">M</span>
                </div>
                <h1 class="text-xl font-bold text-gray-900">MOLE</h1>
            </div>
            <button id="back-btn" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </button>
        </div>
    </header>

    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Profile Info -->
            <div class="lg:col-span-1">
                <div class="card rounded-xl p-6 animate-fade-in">
                    <!-- Profile Image & Basic Info -->
                    <div class="text-center mb-6">
                        @if(isset($topTitle))
                            <div class="mb-4 text-center">
                                <div class="inline-block px-4 py-2 rounded-full shadow-md bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-500 text-white font-semibold text-sm animate-pulse border border-yellow-500">
                                    <svg class="inline w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927C9.372 2.08 10.628 2.08 10.951 2.927l1.07 2.858a1 1 0 00.95.69h3a1 1 0 01.593 1.806l-2.43 1.91a1 1 0 00-.364 1.118l1.07 2.857a1 1 0 01-1.538 1.118l-2.43-1.91a1 1 0 00-1.236 0l-2.43 1.91a1 1 0 01-1.538-1.118l1.07-2.857a1 1 0 00-.364-1.118l-2.43-1.91A1 1 0 014.03 6.475h3a1 1 0 00.95-.69l1.07-2.858z"/>
                                    </svg>
                                    {{ $topTitle }}
                                </div>
                            </div>
                        @endif
                        <div class="relative inline-block">
                            <img src="{{ $user->avatar_url }}"
                                 alt="{{ $user->username ?? 'Profile' }}"
                                 class="w-32 h-32 rounded-full object-cover mx-auto shadow-lg">
                            <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-green-500 rounded-full border-4 border-white">
                                <div class="w-full h-full bg-green-400 rounded-full animate-pulse"></div>
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mt-4">{{ $user->name }}</h2>
                        <p class="text-blue-600 font-medium">{{ '@' .  $user->username }}</p>
                    </div>
                    @if (!$isOwnProfile)
                        <form method="POST" action="{{ route('profile.toggleFollow', $user->buyer_id) }}">
                            @csrf
                            <button type="submit" class="btn-primary w-full justify-center mb-4">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                {{ $isFollowing ? 'Unfollow' : 'Follow' }}
                            </button>
                        </form>
                    @endif
                    <!-- Bio -->
                    @if ($user->bio)
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                        <p class="text-gray-700 text-sm leading-relaxed">{{ $user->bio }}</p>
                    </div>
                    @endif


                    <!-- Contact Info -->
                    <div class="space-y-3 mb-6">
                        @if($user->email)
                        <div class="flex items-center gap-3 text-sm">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-gray-600">{{ $user->email }}</span>
                        </div>
                        @endif

                        @if($user->phone_number)
                        <div class="flex items-center gap-3 text-sm">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span class="text-gray-600">{{ $user->phone_number }}</span>
                        </div>
                        @endif

                        @if($user->address)
                        <div class="flex items-center gap-3 text-sm">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-gray-600">{{ $user->address }}</span>
                        </div>
                        @endif

                        @if($user->birthdate)
                        <div class="flex items-center gap-3 text-sm">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-gray-600">{{ $user->birthdate }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Edit Profile Button -->
                    @if ($isOwnProfile)
                        <button id="edit-profile-btn" class="btn-primary w-full justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Profile
                        </button>
                    @endif
                </div>
            </div>

            <!-- Stats & Activity -->
            <div class="lg:col-span-2 space-y-6">
                <!-- EXP by Category -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ([
                        'loyal_hunter' => 'Loyal Hunter',
                        'bulk_buyer' => 'Bulk Buyer',
                        'premium_collector' => 'Premium Collector'
                    ] as $key => $label)
                        @php $info = $categoryLevels[$key]; @endphp
                        <div class="stat-card p-4 rounded-lg">
                            <h4 class="font-semibold text-sm text-gray-700 mb-1">{{ $label }}</h4>
                            <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden shadow-inner mb-1">
                                <div class="h-full bg-blue-500 transition-all duration-300" style="width: {{ $info['progress'] }}%"></div>
                            </div>
                            <div class="text-xs text-gray-500 flex justify-between">
                                <span>Lvl {{ $info['level'] }}</span>
                                <span>
                                    {{ $info['current_exp'] }} /
                                    {{ $info['next_exp'] ?? 'MAX' }} EXP
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Recent Activity -->
                <div class="card rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
                    @if($posts && $posts->count() > 0)
                    <div class="space-y-3">
                            @foreach($posts->take(3) as $post)
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-sm">{{ Str::limit($post->title, 40) }}</p>
                                    <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $post->likes_count }} ❤️
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <p>No posts yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Edit Profile Button
        @if ($isOwnProfile)
        document.getElementById('edit-profile-btn').addEventListener('click', function () {
            window.location.href = "{{ route('user.profile.edit') }}";
        });
        @endif

        // Back Button
        document.getElementById('back-btn').addEventListener('click', function () {
            window.location.href = "{{ route('dashboard') }}";
        });

        // Coming Soon Function
        function showComingSoon() {
            const modal = document.createElement('div');
            modal.innerHTML = `
                <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg p-6 max-w-sm mx-4">
                        <div class="text-center">
                            <div class="text-4xl mb-4">🚀</div>
                            <h3 class="text-lg font-semibold mb-2">Coming Soon!</h3>
                            <p class="text-gray-600 mb-4">Toys collection feature is under development</p>
                            <button onclick="this.closest('.fixed').remove()" class="btn-primary">
                                Got it!
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }
    </script>

</body>
</html>