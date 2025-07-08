@extends('layout.blank')

@section('title', 'Verifikasi OTP')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
  <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
    <h2 class="text-2xl font-semibold text-center mb-4">Verifikasi OTP</h2>

    @if ($errors->any())
      <div class="bg-red-100 text-red-600 p-2 rounded mb-4 text-sm">
        {{ $errors->first() }}
      </div>
    @endif

    <form action="{{ route('verify.submit') }}" method="POST" class="space-y-4">
      @csrf
      <input type="hidden" name="email" value="{{ old('email', $email) }}">

      <div>
        <label for="otp" class="block text-sm font-medium text-gray-700 mb-1">Kode OTP</label>
        <input type="text" name="otp" id="otp" maxlength="6"
          class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-green-500"
          placeholder="Masukkan 6 digit OTP" required>
      </div>

      <button type="submit"
        class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition-all">
        Verifikasi Kode
      </button>
    </form>
  </div>
</div>
@endsection
