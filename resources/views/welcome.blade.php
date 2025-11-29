@extends('layouts.app', ['title' => 'Welcome'])

@section('content')
<div class="py-10 flex justify-center">
    <div class="flex gap-20">

        {{-- Total Pengajuan --}}
        <div class="bg-white shadow-md rounded-xl p-4 w-[226px] h-[130px] flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-[14px] font-medium">Total Pengajuan</p>
                <h2 class="text-3xl font-bold text-gray-800 leading-tight mt-1">7</h2>
                <p class="text-gray-500 text-[12px] mt-1">Bulan ini</p>
            </div>

            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-list-check text-xl"></i>
            </div>
        </div>

        {{-- Sedang Diproses --}}
        <div class="bg-white shadow-md rounded-xl p-4 w-[226px] h-[130px] flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-[14px] font-medium">Sedang Diproses</p>
                <h2 class="text-3xl font-bold text-gray-800 leading-tight mt-1">5</h2>
                <p class="text-gray-500 text-[12px] mt-1">Dalam antrian</p>
            </div>

            <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-clock text-xl"></i>
            </div>
        </div>

        {{-- Menunggu Verifikasi --}}
        <div class="bg-white shadow-md rounded-xl p-4 w-[226px] h-[130px] flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-[14px] font-medium">Menunggu Verifikasi</p>
                <h2 class="text-3xl font-bold text-gray-800 leading-tight mt-1">7</h2>
                <p class="text-gray-500 text-[12px] mt-1">Perlu Tindakan</p>
            </div>

            <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-triangle-exclamation text-xl"></i>
            </div>
        </div>

        {{-- Surat Selesai --}}
        <div class="bg-white shadow-md rounded-xl p-4 w-[226px] h-[130px] flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-[14px] font-medium">Surat Selesai</p>
                <h2 class="text-3xl font-bold text-gray-800 leading-tight mt-1">8</h2>
                <p class="text-gray-500 text-[12px] mt-1">Siap Diambil</p>
            </div>

            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-check-circle text-xl"></i>
            </div>
        </div>

    </div>
</div>
@endsection
