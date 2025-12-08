@extends('layouts.admin.detail_surat')

@section('content')
    <div class="w-full mx-auto px-6 py-10">

        {{-- Back Button --}}
        <a href="{{ url()->previous() }}"
            class="inline-flex items-center text-gray-600 hover:text-blue-800 mb-8 text-base transition">
            <span class="text-xl mr-2">←</span> Kembali
        </a>
        <div class="bg-white shadow-xl rounded-2xl p-8 mb-12 border border-gray-300">
            <div class="relative w-full flex items-center justify-between px-0 sm:px-6">

                @php
                    // Tentukan step
                    $step = match ($surat->status) {
                        'pending', 'verifikasi' => 1,
                        'proses' => 2,
                        'selesai', 'disetujui', 'ditolak' => 3,
                        default => 1,
                    };

                    // Warna step 3 jika ditolak
                    $step3Color = $surat->status === 'ditolak' ? 'bg-red-600 text-white' : 'bg-blue-600 text-white';
                @endphp

                <div class="relative w-full flex items-center justify-between mt-6">

                    {{-- Garis Progress --}}
                    <div
                        class="absolute top-6 left-[9%] w-[35%] h-[4px] 
        {{ $step >= 2 ? 'bg-blue-500' : 'bg-gray-300' }} rounded-full z-0">
                    </div>

                    <div
                        class="absolute top-6 left-[56%] w-[35%] h-[4px] 
        {{ $step == 3 ? ($surat->status === 'ditolak' ? 'bg-red-500' : 'bg-blue-500') : 'bg-gray-300' }} 
        rounded-full z-0">
                    </div>

                    {{-- STEP 1 --}}
                    <div class="flex flex-col items-center z-10">
                        <div
                            class="w-12 h-12 flex items-center justify-center rounded-full 
            {{ $step >= 1 ? 'bg-blue-600 text-white' : 'bg-gray-300' }}">
                        </div>
                        <span class="mt-2 text-sm">Pengajuan</span>
                    </div>

                    {{-- STEP 2 --}}
                    <div class="flex flex-col items-center z-10">
                        <div
                            class="w-12 h-12 flex items-center justify-center rounded-full 
            {{ $step >= 2 ? 'border-4 border-blue-600 bg-white text-blue-600' : 'bg-gray-300' }}">
                        </div>
                        <span class="mt-2 text-sm">Progress</span>
                    </div>

                    {{-- STEP 3 - selesai atau ditolak --}}
                    <div class="flex flex-col items-center z-10">
                        <div
                            class="w-12 h-12 flex items-center justify-center rounded-full 
            {{ $step == 3 ? $step3Color : 'bg-gray-300' }}">
                        </div>
                        <span class="mt-2 text-sm">
                            {{ $surat->status === 'ditolak' ? 'Ditolak' : 'Disetujui' }}
                        </span>
                    </div>

                </div>
            </div>
        </div>


        {{-- Surat Preview Wrapper (lebar normal seperti awal) --}}
        <div class="bg-white shadow-md rounded-xl p-4 sm:p-6 border border-gray-200 w-full">

            {{-- Jika surat sudah disetujui, tampilkan file asli --}}
            @if ($surat->status === 'disetujui' && $surat->file_surat)
                <iframe src="{{ asset('storage/surat/' . $surat->file_surat) }}" class="w-full h-[800px] border rounded-lg">
                </iframe>
            @else
                {{-- Jika BELUM disetujui, tampilkan preview berdasarkan data_surat --}}

                {{-- Header Surat --}}
                <h2 class="text-xl font-semibold text-gray-900 mb-6 tracking-tight">
                    {{ $surat->jenisSurat->nama_surat }}
                </h2>

                <div class="border border-gray-300 p-5 sm:p-8 text-[13px] leading-relaxed rounded-lg bg-gray-50"
                    style="min-height: 650px;">

                    <div class="text-center mb-6">
                        <p class="text-base font-bold">PEMERINTAH KOTA</p>
                        <p>KELURAHAN EXAMPLE</p>
                        <p class="font-semibold mt-4 tracking-wide text-sm">{{ strtoupper($surat->jenisSurat->nama_surat) }}
                        </p>
                        <p class="text-sm">No : <span class="italic text-gray-500">[Akan diisi oleh admin]</span></p>
                    </div>

                    <p class="mt-6 mb-4 indent-6">
                        Yang bertanda tangan di bawah ini Lurah Example, menerangkan bahwa:
                    </p>

                    <div class="pl-6 space-y-2 text-sm">
                        {{-- Tampilkan semua field dari data_surat --}}
                        @foreach ($surat->data_surat as $key => $value)
                            <div class="flex">
                                <span class="w-40 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                <span class="w-3">:</span>
                                <span class="font-medium">{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>

                    <p class="mt-8 mb-14 leading-relaxed text-sm">
                        Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
                    </p>

                    {{-- Tanda Tangan --}}
                    <div class="flex justify-end">
                        <div class="w-1/2 text-center text-sm">
                            <p>Yogyakarta, {{ $surat->created_at->format('d F Y') }}</p>
                            <p class="mt-14 font-semibold">Lurah Example</p>
                            <p class="italic">[Nama Lurah]</p>
                        </div>
                    </div>

                </div>
            @endif


        </div>





    </div>
@endsection
