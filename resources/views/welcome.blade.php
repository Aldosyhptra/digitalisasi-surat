@extends('layouts.app', ['title' => 'Welcome'])

@section('content')
    <div class="text-center py-16">
        <h1 class="text-4xl font-bold text-gray-800">
            Selamat Datang di Website Kami 👋
        </h1>

        <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
            Ini hanya halaman simulasi untuk memastikan layout dan komponen berjalan dengan baik.
        </p>

        <a href="/about"
            class="inline-block mt-6 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
            Pelajari Lebih Lanjut
        </a>
    </div>
@endsection
