@extends('layout.app')

@section('content')
<style>
/* Modern color palette and subtle effects */
:root {
    --gold: #F59E0B;
    --gold-light: #FDE68A;
    --silver: #6B7280;
    --silver-light: #E5E7EB;
    --bronze: #92400E;
    --bronze-light: #FED7AA;
    --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --glass-bg: rgba(255, 255, 255, 0.1);
    --glass-border: rgba(255, 255, 255, 0.2);
}

/* Subtle glow effects for top 3 */
.crown-gold {
    border: 3px solid var(--gold);
    box-shadow: 0 0 20px rgba(245, 158, 11, 0.3), 0 0 40px rgba(245, 158, 11, 0.1);
}

.crown-silver {
    border: 3px solid var(--silver);
    box-shadow: 0 0 15px rgba(107, 114, 128, 0.3), 0 0 30px rgba(107, 114, 128, 0.1);
}

.crown-bronze {
    border: 3px solid var(--bronze);
    box-shadow: 0 0 15px rgba(146, 64, 14, 0.3), 0 0 30px rgba(146, 64, 14, 0.1);
}

.avatar-container {
    position: relative;
    display: inline-block;
}

.crown-icon {
    position: absolute;
    top: -15px;
    right: -8px;
    font-size: 24px;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
    animation: float 3s ease-in-out infinite;
    z-index: 10;
}

.crown-icon.silver {
    font-size: 20px;
    top: -12px;
    animation-delay: 0.5s;
}

.crown-icon.bronze {
    font-size: 20px;
    top: -12px;
    animation-delay: 1s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

/* Glass morphism cards */
.glass-card {
    background: var(--glass-bg);
    backdrop-filter: blur(10px);
    border: 1px solid var(--glass-border);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}


/* Subtle gradient backgrounds for ranks 4-10 - better contrast */
.rank-4 {
    background: linear-gradient(135deg, #4F46E5 0%, #3730A3 100%);
    color: white;
    backdrop-filter: blur(10px);
}
.rank-5 {
    background: linear-gradient(135deg, #7C3AED 0%, #5B21B6 100%);
    color: white;
    backdrop-filter: blur(10px);
}
.rank-6 {
    background: linear-gradient(135deg, #0EA5E9 0%, #0369A1 100%);
    color: white;
    backdrop-filter: blur(10px);
}
.rank-7 {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    color: white;
    backdrop-filter: blur(10px);
}
.rank-8 {
    background: linear-gradient(135deg, #DC2626 0%, #991B1B 100%);
    color: white;
    backdrop-filter: blur(10px);
}
.rank-9 {
    background: linear-gradient(135deg, #7C2D12 0%, #92400E 100%);
    color: white;
    backdrop-filter: blur(10px);
}
.rank-10 {
    background: linear-gradient(135deg, #374151 0%, #1F2937 100%);
    color: white;
    backdrop-filter: blur(10px);
}

/* Enhanced ranking items */
.ranking-item {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    overflow: hidden;
}

.ranking-item:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.ranking-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.5s;
}

.ranking-item:hover::before {
    left: 100%;
}

/* Enhanced podium cards */
.podium-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.podium-card:hover {
    transform: translateY(-3px) scale(1.05);
}

/* Elegant EXP badges */
.exp-badge {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.1));
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
}

.exp-badge-gold {
    background: linear-gradient(135deg, var(--gold-light), var(--gold));
    color: #92400E;
}

.exp-badge-silver {
    background: linear-gradient(135deg, var(--silver-light), var(--silver));
    color: #374151;
}

.exp-badge-bronze {
    background: linear-gradient(135deg, var(--bronze-light), var(--bronze));
    color: #92400E;
}

/* Tab enhancements */
.tab-btn {
    position: relative;
    background: rgba(248, 250, 252, 0.9); /* putih keabu-abuan */
    backdrop-filter: blur(10px);
    border: 1px solid rgba(203, 213, 225, 0.5); /* border abu-abu muda */
    transition: all 0.3s ease;
    color: #475569; /* teks abu-abu gelap */
}

.tab-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.tab-btn.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: rgba(255, 255, 255, 0.3);
}

/* Stats card enhancement */
.stats-card {
    background: var(--glass-bg);
    backdrop-filter: blur(15px);
    border: 1px solid var(--glass-border);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

/* Responsive improvements */
@media (max-width: 768px) {
    .podium-container {
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .podium-card {
        width: 200px;
        height: 100px;
        flex-direction: row;
        justify-content: flex-start;
        padding: 1rem;
    }
}
</style>

<!-- Header with gradient background -->
<div class="container mx-auto p-4 glass-card text-white text-center py-6 text-3xl font-bold shadow-lg" style="background: var(--bg-gradient);">
    <div class="flex items-center justify-center gap-3">
        <span class="text-4xl">🏆</span>
        LEADERBOARD
        <span class="text-4xl">🏆</span>
    </div>
</div>

<!-- Enhanced Tabs -->
<div class="flex justify-center mt-8 gap-4">
    <button class="tab-btn px-6 py-3 rounded-full font-semibold transition-all {{ $type == 'bulk_buyer' ? 'active' : '' }}"
            data-type="bulk_buyer">
        <span class="mr-2">🛒</span>Bulk Buyer
    </button>
    <button class="tab-btn px-6 py-3 rounded-full font-semibold transition-all {{ $type == 'loyal_hunter' ? 'active' : '' }}"
            data-type="loyal_hunter">
        <span class="mr-2">🔥</span>Loyal Hunter
    </button>
    <button class="tab-btn px-6 py-3 rounded-full font-semibold transition-all {{ $type == 'premium_collector' ? 'active' : '' }}"
            data-type="premium_collector">
        <span class="mr-2">💎</span>Premium Collector
    </button>
</div>

<!-- Enhanced Top 3 Layout -->
<div class="flex justify-center items-end mt-12 gap-6 podium-container">
    @if(isset($leaderboards[2]))
    <!-- Top 3 -->
    <div class="podium-card glass-card text-gray-800 rounded-2xl w-32 h-40 flex flex-col items-center justify-center shadow-lg font-semibold">
        <div class="text-2xl mb-2">3rd</div>
        <div class="avatar-container mb-2">
            <div class="w-16 h-16 rounded-full crown-bronze overflow-hidden">
                <img src="{{ $leaderboards[2]->buyer->avatar ? asset('storage/' . $leaderboards[2]->buyer->avatar) : asset('images/muka.jpg') }}"
                     alt="Avatar" class="w-full h-full object-cover">
            </div>
            <div class="crown-icon bronze">🥉</div>
        </div>
        <div class="text-sm text-center px-2 font-medium">{{ Str::limit($leaderboards[2]->buyer->username ?? 'User', 10) }}</div>
    </div>
    @endif

    @if(isset($leaderboards[0]))
    <!-- Top 1 -->
    <div class="podium-card glass-card text-gray-800 rounded-2xl w-36 h-48 flex flex-col items-center justify-center shadow-xl font-bold">
        <div class="text-3xl mb-2">1st</div>
        <div class="avatar-container mb-2">
            <div class="w-20 h-20 rounded-full crown-gold overflow-hidden">
                <img src="{{ $leaderboards[0]->buyer->avatar ? asset('storage/' . $leaderboards[0]->buyer->avatar) : asset('images/muka.jpg') }}"
                     alt="Avatar" class="w-full h-full object-cover">
            </div>
            <div class="crown-icon">👑</div>
        </div>
        <div class="text-base text-center px-2 font-semibold">{{ Str::limit($leaderboards[0]->buyer->username ?? 'User', 10) }}</div>
    </div>
    @endif

    @if(isset($leaderboards[1]))
    <!-- Top 2 -->
    <div class="podium-card glass-card text-gray-800 rounded-2xl w-32 h-40 flex flex-col items-center justify-center shadow-lg font-semibold">
        <div class="text-2xl mb-2">2nd</div>
        <div class="avatar-container mb-2">
            <div class="w-16 h-16 rounded-full crown-silver overflow-hidden">
                <img src="{{ $leaderboards[1]->buyer->avatar ? asset('storage/' . $leaderboards[1]->buyer->avatar) : asset('images/muka.jpg') }}"
                     alt="Avatar" class="w-full h-full object-cover">
            </div>
            <div class="crown-icon silver">🥈</div>
        </div>
        <div class="text-sm text-center px-2 font-medium">{{ Str::limit($leaderboards[1]->buyer->username ?? 'User', 10) }}</div>
    </div>
    @endif
</div>

<!-- Empty State for Top 3 -->
@if($leaderboards->count() == 0)
<div class="flex justify-center items-end mt-12 gap-6">
    <div class="glass-card text-gray-500 rounded-2xl w-32 h-40 flex flex-col items-center justify-center shadow-lg">
        <div class="text-2xl mb-2">3rd</div>
        <div class="w-16 h-16 rounded-full bg-gray-300 mb-2"></div>
        <div class="text-sm">Kosong</div>
    </div>
    <div class="glass-card text-gray-500 rounded-2xl w-36 h-48 flex flex-col items-center justify-center shadow-lg">
        <div class="text-3xl mb-2">1st</div>
        <div class="w-20 h-20 rounded-full bg-gray-300 mb-2"></div>
        <div class="text-sm">Kosong</div>
    </div>
    <div class="glass-card text-gray-500 rounded-2xl w-32 h-40 flex flex-col items-center justify-center shadow-lg">
        <div class="text-2xl mb-2">2nd</div>
        <div class="w-16 h-16 rounded-full bg-gray-300 mb-2"></div>
        <div class="text-sm">Kosong</div>
    </div>
</div>
@endif

<!-- Enhanced Top 4 - 10 List -->
<div class="max-w-lg mx-auto mt-12 space-y-4">
    @if($leaderboards->count() > 3)
        @foreach($leaderboards->slice(3) as $index => $leader)
        <div class="ranking-item rank-{{ $index + 4 }} text-white py-4 px-6 rounded-2xl flex justify-between items-center font-medium shadow-lg">
            <div class="flex items-center gap-4">
                <div class="font-bold bg-white bg-opacity-20 rounded-full w-10 h-10 flex items-center justify-center text-lg">{{ $index + 4 }}</div>
                <div class="w-12 h-12 rounded-full border-2 border-white border-opacity-50 overflow-hidden">
                    <img src="{{ $leader->buyer->avatar ? asset('storage/' . $leader->buyer->avatar) : asset('images/muka.jpg') }}"
                         alt="Avatar" class="w-full h-full object-cover">
                </div>
                <div>
                    <div class="font-semibold">{{ $leader->buyer->username ?? 'User' }}</div>
                    <div class="text-xs opacity-75">{{ $leader->buyer->email ?? 'user@example.com' }}</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-lg font-bold exp-badge px-3 py-1 rounded-full">{{ number_format($leader->exp) }}</div>
                <div class="text-xs opacity-75 mt-1">EXP</div>
            </div>
        </div>
        @endforeach
    @else
        @for($i = 4; $i <= 10; $i++)
        <div class="ranking-item rank-{{ $i }} text-white py-4 px-6 rounded-2xl flex justify-between items-center font-medium shadow-lg opacity-40">
            <div class="flex items-center gap-4">
                <div class="font-bold bg-white bg-opacity-20 rounded-full w-10 h-10 flex items-center justify-center text-lg">{{ $i }}</div>
                <div class="w-12 h-12 rounded-full bg-white bg-opacity-20"></div>
                <div>
                    <div class="font-semibold">Belum ada peserta</div>
                    <div class="text-xs opacity-75">Slot kosong</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-lg font-bold exp-badge px-3 py-1 rounded-full">0</div>
                <div class="text-xs opacity-75 mt-1">EXP</div>
            </div>
        </div>
        @endfor
    @endif
</div>

<!-- Enhanced JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.tab-btn');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            tabBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');

            const type = this.dataset.type;
            window.location.href = `{{ route('leaderboard.index') }}?type=${type}`;
        });
    });

    // Add loading animation
    const rankingItems = document.querySelectorAll('.ranking-item');
    rankingItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        setTimeout(() => {
            item.style.transition = 'all 0.5s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>

@endsection