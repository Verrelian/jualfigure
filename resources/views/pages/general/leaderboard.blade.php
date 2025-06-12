@extends('layout.app')

@section('content')
  <!-- Header -->
  <div class="container mx-auto p-4 bg-white bg-opacity-80 text-black text-center py-4 text-2xl font-bold shadow-md">
    LEADERBOARD
  </div>

  <!-- Tabs -->
  <div class="flex justify-center mt-6 gap-3">
    <button class="bg-white bg-opacity-70 hover:bg-opacity-90 px-5 py-2 rounded-full font-medium shadow transition-all">Bulk Buyer</button>
    <button class="bg-white bg-opacity-70 hover:bg-opacity-90 px-5 py-2 rounded-full font-medium shadow transition-all">Loyal Hunter</button>
    <button class="bg-white bg-opacity-70 hover:bg-opacity-90 px-5 py-2 rounded-full font-medium shadow transition-all">Premium Collector</button>
  </div>

  <!-- Top 3 Layout -->
  <div class="flex justify-center items-end mt-10 gap-4">
    <!-- Top 3 -->
    <div class="bg-white bg-opacity-80 text-black rounded-xl w-24 h-28 flex items-center justify-center shadow-md font-semibold">Top 3</div>
    <!-- Top 1 -->
    <div class="bg-white bg-opacity-90 text-black rounded-xl w-28 h-32 flex items-center justify-center shadow-lg font-bold text-lg">Top 1</div>
    <!-- Top 2 -->
    <div class="bg-white bg-opacity-80 text-black rounded-xl w-24 h-28 flex items-center justify-center shadow-md font-semibold">Top 2</div>
  </div>

  <!-- Top 4 - 10 List -->
  <div class="max-w-md mx-auto mt-10 space-y-3">
    <div class="bg-white bg-opacity-70 text-black py-2 rounded-full text-center font-medium shadow">Top 4</div>
    <div class="bg-white bg-opacity-70 text-black py-2 rounded-full text-center font-medium shadow">Top 5</div>
    <div class="bg-white bg-opacity-70 text-black py-2 rounded-full text-center font-medium shadow">Top 6</div>
    <div class="bg-white bg-opacity-70 text-black py-2 rounded-full text-center font-medium shadow">Top 7</div>
    <div class="bg-white bg-opacity-70 text-black py-2 rounded-full text-center font-medium shadow">Top 8</div>
    <div class="bg-white bg-opacity-70 text-black py-2 rounded-full text-center font-medium shadow">Top 9</div>
    <div class="bg-white bg-opacity-70 text-black py-2 rounded-full text-center font-medium shadow">Top 10</div>
  </div>

</body>
</html>
@endsection