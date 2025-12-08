@extends('layouts.pengajuan_surat')

@section('content')
    <div class="w-full mx-auto px-6 py-10">

        {{-- Back Button --}}
        <a href="{{ url()->previous() }}"
            class="inline-flex items-center text-gray-600 hover:text-blue-800 mb-8 text-base transition">
            <span class="text-xl mr-2">←</span> Kembali
        </a>

        {{-- Progress Step --}}
        <div class="bg-white shadow-xl rounded-2xl p-8 mb-12 border border-gray-300">
            <div class="relative w-full flex items-center justify-between px-0 sm:px-6">

                @php
                    // Tentukan apakah sudah selesai (disetujui/ditolak)
                    $isSelesai = in_array($surat->status, ['selesai', 'disetujui', 'ditolak']);
                    $step3Color = $surat->status === 'ditolak' ? 'bg-red-600 text-white' : 'bg-green-600 text-white';
                @endphp

                <div class="relative w-full flex items-center justify-between mt-6">

                    {{-- Garis Progress --}}
                    <div
                        class="absolute top-7 left-[9%] w-[35%] h-[4px] bg-blue-500 rounded-full z-0 transition-all duration-500">
                    </div>
                    <div
                        class="absolute top-7 left-[56%] w-[35%] h-[4px] {{ $isSelesai ? ($surat->status === 'ditolak' ? 'bg-red-500' : 'bg-green-500') : 'bg-gray-300' }} rounded-full z-0 transition-all duration-500">
                    </div>

                    {{-- STEP 1: Pengajuan (selalu biru) --}}
                    <div class="flex flex-col items-center z-10">
                        <div
                            class="w-14 h-14 flex items-center justify-center rounded-full bg-blue-600 text-white shadow-lg transition-all duration-300">
                            {{-- Icon Document/Paper --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="mt-3 text-sm font-semibold text-blue-600">Pengajuan</span>
                    </div>

                    {{-- STEP 2: Sedang Diproses / Sudah Diproses --}}
                    <div class="flex flex-col items-center z-10">
                        <div
                            class="relative w-14 h-14 flex items-center justify-center rounded-full bg-blue-600 text-white shadow-lg transition-all duration-300">

                            @if (!$isSelesai)
                                {{-- Animasi buffering spinner (hanya tampil saat BELUM selesai) --}}
                                <svg class="animate-spin absolute inset-0 w-full h-full" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white"
                                        stroke-width="3"></circle>
                                    <path class="opacity-75" fill="white"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            @endif

                            {{-- Icon Clock --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 relative z-10" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="mt-3 text-sm font-semibold text-blue-600">
                            {{ $isSelesai ? 'Sudah Diproses' : 'Sedang Diproses' }}
                        </span>
                        @if (!$isSelesai)
                            <span class="text-xs text-blue-500 mt-1 animate-pulse">Mohon tunggu...</span>
                        @endif
                    </div>

                    {{-- STEP 3: Disetujui/Ditolak --}}
                    <div class="flex flex-col items-center z-10">
                        <div
                            class="w-14 h-14 flex items-center justify-center rounded-full {{ $isSelesai ? $step3Color . ' shadow-lg' : 'bg-gray-300 text-gray-500' }} transition-all duration-300">
                            @if ($isSelesai)
                                @if ($surat->status === 'ditolak')
                                    {{-- Icon X (Ditolak) --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                @else
                                    {{-- Icon Check (Disetujui) --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                @endif
                            @else
                                {{-- Icon default saat belum selesai --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                        </div>
                        <span
                            class="mt-3 text-sm font-semibold {{ $isSelesai ? ($surat->status === 'ditolak' ? 'text-red-600' : 'text-green-600') : 'text-gray-500' }}">
                            {{ $surat->status === 'ditolak' ? 'Ditolak' : 'Disetujui' }}
                        </span>
                    </div>

                </div>
            </div>
        </div>

        {{-- PDF Preview dengan iframe --}}
        <div class="bg-white shadow-md rounded-xl p-4 sm:p-6 border border-gray-200 w-full">
            @if ($surat->file_surat)
                <iframe src="{{ route('surat.preview', $surat->id) }}#toolbar=0"
                    class="w-full border border-gray-300 rounded shadow-sm" style="height: 850px; min-height: 600px;"
                    title="Preview Surat PDF" frameborder="0">
                </iframe>
            @else
                <p class="text-center text-gray-500 py-10">Surat belum tersedia untuk preview.</p>
            @endif
        </div>

    </div>
@endsection
