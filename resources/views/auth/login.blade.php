@extends('layouts.auth')

@section('content')
    <h2 class="text-3xl font-bold text-gray-800 text-center mb-2">
        Selamat Datang
    </h2>
    <p class="text-gray-500 text-center mb-8">
        Silakan masuk untuk melanjutkan
    </p>

    <form action="{{ route('login.process') }}" method="POST" class="space-y-5">
        @csrf

        {{-- EMAIL / NIK / USERNAME --}}
        <div>
            <label class="font-semibold text-gray-700">Email / NIK / Username</label>
            <input type="text" name="username" placeholder="contoh: penduduk / admin" required
                class="w-full border border-gray-300 rounded-lg px-4 py-3 mt-1
                      focus:ring-2 focus:ring-blue-400 outline-none transition">
        </div>

        {{-- PASSWORD --}}
        <div>
            <label class="font-semibold text-gray-700">Password</label>
            <input type="password" name="password" placeholder="•••••••" required
                class="w-full border border-gray-300 rounded-lg px-4 py-3 mt-1
                      focus:ring-2 focus:ring-blue-400 outline-none transition">
        </div>

        {{-- Remember + Forgot --}}
        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2 text-gray-600">
                <input type="checkbox" class="w-4 h-4" name="remember">
                Ingat saya
            </label>

            <a href="#" class="text-blue-600 hover:underline">Lupa password?</a>
        </div>

        {{-- BUTTON LOGIN --}}
        <button
            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold
               hover:bg-blue-700 active:bg-blue-800 transition shadow-md">
            Masuk
        </button>

        {{-- ERROR MESSAGE --}}
        @if (session('error'))
            <p class="text-red-500 text-center text-sm mt-2">
                {{ session('error') }}
            </p>
        @endif

    </form>

    {{-- REGISTER LINK --}}
    <p class="text-center text-gray-600 mt-6">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">
            Daftar sekarang
        </a>
    </p>

    {{-- SOCIAL LOGIN --}}
    <div class="mt-8">
        <p class="text-center text-gray-500 mb-3">Atau masuk dengan</p>

        <div class="flex items-center justify-center gap-4">

            <a href="#"
                class="w-12 h-12 flex items-center justify-center rounded-full
                  border border-gray-300 hover:bg-gray-100 transition">
                <img src="/icons/google.svg" class="w-5">
            </a>

            <a href="#"
                class="w-12 h-12 flex items-center justify-center rounded-full
                  border border-gray-300 hover:bg-gray-100 transition">
                <img src="/icons/facebook.svg" class="w-5">
            </a>

            <a href="#"
                class="w-12 h-12 flex items-center justify-center rounded-full
                  border border-gray-300 hover:bg-gray-100 transition">
                <img src="/icons/apple.svg" class="w-5">
            </a>

        </div>
    </div>
@endsection
