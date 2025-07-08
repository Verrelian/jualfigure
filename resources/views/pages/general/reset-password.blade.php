@extends('layout.blank')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
  <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
    <h2 class="text-2xl font-semibold text-center mb-4">Reset Password</h2>

    @if ($errors->any())
      <div class="bg-red-100 text-red-600 p-2 rounded mb-4 text-sm">
        {{ $errors->first() }}
      </div>
    @endif

    <form action="{{ route('reset.submit') }}" method="POST" class="space-y-4">
      @csrf
      <input type="hidden" name="email" value="{{ $email }}">
      <input type="hidden" name="otp" value="{{ $otp }}">

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
        <input type="password" name="password" id="password"
          class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-green-500"
          required placeholder="Masukkan password baru">
      </div>

      <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation"
          class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-green-500"
          required placeholder="Ulangi password baru">
      </div>

      <button type="submit"
        class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition-all">
        Simpan Password Baru
      </button>
    </form>
  </div>
</div>
@endsection
