@extends('layout.app')

@section('title', 'Order Detail')

@section('content')
    <div class="bg-[#1a1a1a] text-white p-6 rounded-xl">
        <div class="mb-4">
            <h1 class="text-2xl font-bold">#3321345</h1>
            <p class="text-sm text-gray-400">22 August 2005, 05:10 am</p>
        </div>
        <p class="text-sm mb-3 text-gray-300">Estimated Delivery: 3-5 business days</p>

        @include('component.item-info')

        <div class="mt-4">
            <label for="payment-method" class="block mb-2">Payment Method</label>
            <select id="payment-method" class="w-full p-2 rounded-md text-black">
                <option>Virtual</option>
                <option>Bank Transfer</option>
            </select>
        </div>

        @include('component.price-detail')

        <div class="mt-4 text-right">
        <button class="bg-red-300 text-black py-2 px-6 rounded-full font-semibold">Back</button>    
        <button class="bg-gray-300 text-black py-2 px-6 rounded-full font-semibold">Checkout</button>
        </div>
    </div>
@endsection
