@extends('layout.app')

@section('content')
<!-- Header -->
<div class="container mx-auto p-4 bg-white bg-opacity-80 text-black text-center py-4 text-2xl font-bold shadow-md">
    LEADERBOARD
</div>

<!-- Tabs -->
<div class="flex justify-center mt-6 gap-3">
    <button class="tab-btn bg-white bg-opacity-70 hover:bg-opacity-90 px-5 py-2 rounded-full font-medium shadow transition-all {{ $type == 'bulk_buyer' ? 'bg-opacity-90 ring-2 ring-blue-400' : '' }}"
            data-type="bulk_buyer">Bulk Buyer</button>
    <button class="tab-btn bg-white bg-opacity-70 hover:bg-opacity-90 px-5 py-2 rounded-full font-medium shadow transition-all {{ $type == 'loyal_hunter' ? 'bg-opacity-90 ring-2 ring-blue-400' : '' }}"
            data-type="loyal_hunter">Loyal Hunter</button>
    <button class="tab-btn bg-white bg-opacity-70 hover:bg-opacity-90 px-5 py-2 rounded-full font-medium shadow transition-all {{ $type == 'premium_collector' ? 'bg-opacity-90 ring-2 ring-blue-400' : '' }}"
            data-type="premium_collector">Premium Collector</button>
</div>

<!-- Category Description -->
<div class="text-center mt-4 px-4">
    <p class="text-sm text-gray-600 bg-white bg-opacity-70 rounded-lg px-4 py-2 inline-block">
        @if($type == 'bulk_buyer')
            🛒 Berdasarkan jumlah item yang dibeli (10 EXP per item)
        @elseif($type == 'loyal_hunter')
            🔥 Berdasarkan jumlah transaksi (50 EXP per transaksi)
        @else
            💎 Berdasarkan total pembelian (1 EXP per 1.000 rupiah)
        @endif
    </p>
</div>

<!-- Top 3 Layout -->
<div class="flex justify-center items-end mt-10 gap-4">
    @if(isset($leaderboards[2]))
    <!-- Top 3 -->
    <div class="bg-white bg-opacity-80 text-black rounded-xl w-24 h-28 flex flex-col items-center justify-center shadow-md font-semibold">
        <div class="text-lg">🥉</div>
        <div class="text-xs text-center px-1">{{ Str::limit($leaderboards[2]->buyer->username ?? 'User', 8) }}</div>
        <div class="text-xs font-bold text-orange-600">{{ number_format($leaderboards[2]->exp) }} EXP</div>
    </div>
    @endif

    @if(isset($leaderboards[0]))
    <!-- Top 1 -->
    <div class="bg-white bg-opacity-90 text-black rounded-xl w-28 h-32 flex flex-col items-center justify-center shadow-lg font-bold">
        <div class="text-xl">👑</div>
        <div class="text-sm text-center px-1">{{ Str::limit($leaderboards[0]->buyer->username ?? 'User', 8) }}</div>
        <div class="text-xs font-bold text-yellow-600">{{ number_format($leaderboards[0]->exp) }} EXP</div>
    </div>
    @endif

    @if(isset($leaderboards[1]))
    <!-- Top 2 -->
    <div class="bg-white bg-opacity-80 text-black rounded-xl w-24 h-28 flex flex-col items-center justify-center shadow-md font-semibold">
        <div class="text-lg">🥈</div>
        <div class="text-xs text-center px-1">{{ Str::limit($leaderboards[1]->buyer->username ?? 'User', 8) }}</div>
        <div class="text-xs font-bold text-gray-600">{{ number_format($leaderboards[1]->exp) }} EXP</div>
    </div>
    @endif
</div>

<!-- Empty State for Top 3 -->
@if($leaderboards->count() == 0)
<div class="flex justify-center items-end mt-10 gap-4">
    <div class="bg-white bg-opacity-50 text-gray-400 rounded-xl w-24 h-28 flex flex-col items-center justify-center shadow-md">
        <div class="text-lg">🥉</div>
        <div class="text-xs">Belum Ada</div>
    </div>
    <div class="bg-white bg-opacity-50 text-gray-400 rounded-xl w-28 h-32 flex flex-col items-center justify-center shadow-md">
        <div class="text-xl">👑</div>
        <div class="text-xs">Belum Ada</div>
    </div>
    <div class="bg-white bg-opacity-50 text-gray-400 rounded-xl w-24 h-28 flex flex-col items-center justify-center shadow-md">
        <div class="text-lg">🥈</div>
        <div class="text-xs">Belum Ada</div>
    </div>
</div>
@endif

<!-- Top 4 - 10 List -->
<div class="max-w-md mx-auto mt-10 space-y-3">
    @if($leaderboards->count() > 3)
        @foreach($leaderboards->slice(3) as $index => $leader)
        <div class="bg-white bg-opacity-70 text-black py-3 px-4 rounded-full flex justify-between items-center font-medium shadow">
            <div class="flex items-center gap-3">
                <span class="font-bold text-gray-600">{{ $index + 4 }}.</span>
                <span>{{ $leader->buyer->username ?? 'User' }}</span>
            </div>
            <span class="text-sm font-bold text-blue-600">{{ number_format($leader->exp) }} EXP</span>
        </div>
        @endforeach
    @else
        @for($i = 4; $i <= 10; $i++)
        <div class="bg-white bg-opacity-50 text-gray-400 py-3 px-4 rounded-full flex justify-between items-center font-medium shadow">
            <div class="flex items-center gap-3">
                <span class="font-bold">{{ $i }}.</span>
                <span>Belum ada peserta</span>
            </div>
            <span class="text-sm">0 EXP</span>
        </div>
        @endfor
    @endif
</div>

<!-- Stats Summary -->
@if($leaderboards->count() > 0)
<div class="max-w-md mx-auto mt-8 p-4 bg-white bg-opacity-70 rounded-lg shadow">
    <h3 class="text-center font-bold mb-3">📊 Stats Summary</h3>
    <div class="grid grid-cols-3 gap-4 text-center text-xs">
        <div>
            <div class="font-bold text-blue-600">{{ $leaderboards->sum('total_items') }}</div>
            <div class="text-gray-600">Total Items</div>
        </div>
        <div>
            <div class="font-bold text-green-600">{{ $leaderboards->sum('total_transactions') }}</div>
            <div class="text-gray-600">Total Transaksi</div>
        </div>
        <div>
            <div class="font-bold text-purple-600">Rp {{ number_format($leaderboards->sum('total_spent')) }}</div>
            <div class="text-gray-600">Total Spent</div>
        </div>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.tab-btn');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const type = this.dataset.type;
            window.location.href = `{{ route('leaderboard.index') }}?type=${type}`;
        });
    });
});
</script>

@endsection