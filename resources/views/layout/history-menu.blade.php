@extends('layout.app')

@section('hideFeedExplore')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="border-b border-gray-200 mb-6">
        <nav class="flex justify-center space-x-8 overflow-x-auto overflow-y-hidden -mb-px">
            <a href="{{ route('history.placed') }}"
                class="{{ request()->routeIs('history.placed*') 
               ? 'border-indigo-500 text-indigo-600 bg-indigo-50' 
               : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
          whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Order Placed
            </a>
            <a href="{{ route('history.process') }}"
                class="{{ request()->routeIs('history.process*') 
               ? 'border-indigo-500 text-indigo-600 bg-indigo-50' 
               : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
          whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Process
            </a>
            <a href="{{ route('history.shipping') }}"
                class="{{ request()->routeIs('history.shipping*') 
               ? 'border-indigo-500 text-indigo-600 bg-indigo-50' 
               : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
          whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Shipping
            </a>
            <a href="{{ route('history.delivered') }}"
                class="{{ request()->routeIs('history.delivered*') 
               ? 'border-indigo-500 text-indigo-600 bg-indigo-50' 
               : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
          whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Delivered
            </a>
            <a href="{{ route('history.canceled') }}"
                class="{{ request()->routeIs('history.canceled*') 
               ? 'border-indigo-500 text-indigo-600 bg-indigo-50' 
               : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
          whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Order Canceled
            </a>
            <a href="{{ route('history.completed') }}"
                class="{{ request()->routeIs('history.completed*') 
               ? 'border-indigo-500 text-indigo-600 bg-indigo-50' 
               : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
          whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Order Completed
            </a>
        </nav>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @yield('historyContent')
    </div>
</div>
@endsection
@endsection