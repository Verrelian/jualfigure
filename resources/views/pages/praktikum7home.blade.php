@extends('layout.praktikum7')

@section('title', 'Home')
@section('page_title', 'Selamat datang di Berita Batam')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Selamat Pagi</h1>
    <p class="mb-4">Berikut adalah berita update di hari ini</p>

    @include('component.praktikum7card', [
        'imgsrc' => 'images/p4.jpg',
        'title' => 'Gonggong goreng Tepung  Limah',
        'desc' => 'Kuliner unik satu ini wajib dicoba untuk menguji ketahanan gigi.'
    ])

    @include('component.praktikum7card', [
        'imgsrc' => 'images/p1.jpg',
        'title' => 'T',
        'desc' => 'Kuliner unik satu ini wajib dicoba untuk menguji ketahanan gigi.'
    ])

@endsection
