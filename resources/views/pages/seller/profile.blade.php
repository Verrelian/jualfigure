<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ $user->name }} - Seller Profile</title>
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
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            padding: 14px 28px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 1rem;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        .btn-secondary {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #475569;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 1rem;
        }
        .btn-secondary:hover {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen text-gray-800 font-sans text-[18px]">

    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="MOLE Logo" class="w-full h-full object-contain">
                    </div>
                    <h1 class="text-xl font-bold text-gray-900">MOLE</h1>
                </div>
            <button onclick="window.location.href='{{ route('seller.dashboard') }}'" class="btn-secondary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex justify-center">
            <!-- Sidebar Info -->
            <div class="w-full md:w-3/4 lg:w-2/3 xl:w-1/2">
                <div class="card rounded-2xl p-8 animate-fade-in text-center shadow-xl">
                    <div class="relative inline-block mb-6">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/muka.jpg') }}"
                             alt="{{ $user->username ?? 'Profile' }}"
                             class="w-40 h-40 rounded-full object-cover mx-auto shadow-lg border-4 border-blue-500">
                    </div>
                    <h2 class="text-3xl font-bold mb-1">{{ $user->name }}</h2>
                    <p class="text-blue-600 text-lg font-medium mb-6">{{ '@' . $user->username }}</p>

                    <div class="text-left mt-4 text-[17px] space-y-4 text-gray-700 leading-relaxed">
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Phone:</strong> {{ $user->phone_number }}</p>
                        <p><strong>Address:</strong> {{ $user->address ?? '-' }}</p>
                        <p><strong>Birthdate:</strong> {{ $user->birthdate ?? '-' }}</p>
                        <p><strong>Bio:</strong> {{ $user->bio ?? '-' }}</p>
                    </div>

                    <button onclick="window.location.href='{{ route('seller.edit_profile') }}'" class="btn-primary w-full mt-8">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
