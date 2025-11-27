@extends('layouts.auth')

@section('content')
    <h2 class="text-3xl font-bold text-gray-800 text-center mb-2">
        Daftar Akun Baru
    </h2>
    <p class="text-gray-500 text-center mb-8">
        Lengkapi data Anda untuk membuat akun
    </p>

    {{-- Alert Success --}}
    @if (session('success'))
        <div x-data="{ open: true }" x-show="open" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl p-8 text-center w-[90%] max-w-md animate-fade-in">
                <h3 class="text-xl font-bold text-green-600 mb-2">Berhasil!</h3>
                <p class="text-gray-600 mb-5">{{ session('success') }}</p>

                <button @click="open = false"
                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    Tutup
                </button>
            </div>
        </div>
    @endif

    {{-- Alert Error --}}
    @if (session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-3"></i>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">
            <div class="flex items-start">
                <i class="fas fa-exclamation-circle mr-3 mt-1"></i>
                <div>
                    <p class="font-semibold mb-2">Terdapat kesalahan:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('register.process') }}" method="POST" class="space-y-6">
        @csrf

        {{-- NAMA + NIK --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="font-semibold text-gray-700">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama" value="{{ old('nama') }}" required
                    placeholder="Masukkan nama lengkap"
                    class="w-full border rounded-lg px-4 py-3 mt-1 transition outline-none
                              @error('nama') border-red-500 @else border-gray-300 focus:ring-2 focus:ring-blue-400 @enderror">
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="font-semibold text-gray-700">
                    NIK <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nik" value="{{ old('nik') }}" required maxlength="16"
                    placeholder="Nomor Induk Kependudukan (16 digit)"
                    class="w-full border rounded-lg px-4 py-3 mt-1 transition outline-none
                              @error('nik') border-red-500 @else border-gray-300 focus:ring-2 focus:ring-blue-400 @enderror">
                @error('nik')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Harus 16 digit angka</p>
            </div>
        </div>

        {{-- USERNAME --}}
        <div>
            <label class="font-semibold text-gray-700">
                Username <span class="text-red-500">*</span>
            </label>
            <input type="text" name="username" value="{{ old('username') }}" required placeholder="Buat username"
                class="w-full border rounded-lg px-4 py-3 mt-1 transition outline-none
                          @error('username') border-red-500 @else border-gray-300 focus:ring-2 focus:ring-blue-400 @enderror">
            @error('username')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- TANGGAL LAHIR + NOMOR WA --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="font-semibold text-gray-700">
                    Tanggal Lahir <span class="text-red-500">*</span>
                </label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                    max="{{ date('Y-m-d') }}"
                    class="w-full border rounded-lg px-4 py-3 mt-1 transition outline-none
                              @error('tanggal_lahir') border-red-500 @else border-gray-300 focus:ring-2 focus:ring-blue-400 @enderror">
                @error('tanggal_lahir')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="font-semibold text-gray-700">
                    Nomor WhatsApp <span class="text-red-500">*</span>
                </label>
                <input type="text" name="no_wa" value="{{ old('no_wa') }}" required placeholder="08xxxxxxxxxx"
                    class="w-full border rounded-lg px-4 py-3 mt-1 transition outline-none
                              @error('no_wa') border-red-500 @else border-gray-300 focus:ring-2 focus:ring-blue-400 @enderror">
                @error('no_wa')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Format: 08xxxxxxxxxx (10-15 digit)</p>
            </div>
        </div>

        {{-- PASSWORD --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="font-semibold text-gray-700">
                    Password <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter"
                    class="w-full border rounded-lg px-4 py-3 mt-1 transition outline-none
                              @error('password') border-red-500 @else border-gray-300 focus:ring-2 focus:ring-blue-400 @enderror">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="font-semibold text-gray-700">
                    Konfirmasi Password <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password_confirmation" required placeholder="Ulangi password"
                    class="w-full border rounded-lg px-4 py-3 mt-1 transition outline-none
                              border-gray-300 focus:ring-2 focus:ring-blue-400">
            </div>
        </div>

        {{-- BUTTON --}}
        <button type="submit"
            class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold
                   hover:bg-green-700 active:bg-green-800 transition shadow-md
                   flex items-center justify-center gap-2">
            <i class="fas fa-user-plus"></i>
            <span>Buat Akun</span>
        </button>
    </form>

    <p class="text-center text-gray-600 mt-6">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">
            Masuk sekarang
        </a>
    </p>
@endsection
