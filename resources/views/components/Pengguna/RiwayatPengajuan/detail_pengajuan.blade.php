@extends('layouts.pengajuan_surat')

@section('content')
    <div class="w-full mx-auto px-6 py-10">

        {{-- Back Button --}}
        <a href="{{ url()->previous() }}"
            class="inline-flex items-center text-gray-600 hover:text-blue-800 mb-8 text-base transition">
            <span class="text-xl mr-2">←</span> Kembali
        </a>
        <div class="bg-white shadow-xl rounded-2xl p-8 mb-12 border border-gray-300">
            <div class="relative w-full flex items-center justify-between px-0 sm:px-6">

                {{-- Garis Progress (pendek, tidak menyentuh lingkaran) --}}
                <div class="absolute top-6 left-[18%] w-[14%] h-[4px] bg-blue-500 z-0 rounded-full"></div>
                <div class="absolute top-6 left-[43%] w-[14%] h-[4px] bg-gray-300 z-0 rounded-full"></div>
                <div class="absolute top-6 left-[68%] w-[14%] h-[4px] bg-gray-300 z-0 rounded-full"></div>

                {{-- Step 1 (Done) --}}
                <div class="flex flex-col items-center w-1/4 relative z-10">
                    <div
                        class="w-12 h-12 flex items-center justify-center rounded-full bg-blue-600 text-white font-bold shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="mt-3 text-sm font-semibold text-blue-700">Diajukan</p>
                </div>

                {{-- Step 2 (Active) --}}
                <div class="flex flex-col items-center w-1/4 relative z-10">
                    <div
                        class="w-12 h-12 flex items-center justify-center rounded-full bg-white text-blue-600 border-4 border-blue-600 shadow-md">
                    </div>
                    <p class="mt-3 text-sm font-semibold text-blue-700">Diverifikasi</p>
                </div>

                {{-- Step 3 --}}
                <div class="flex flex-col items-center w-1/4 relative z-10">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-300 text-gray-600 shadow">
                    </div>
                    <p class="mt-3 text-sm font-semibold text-gray-600">Diproses</p>
                </div>

                {{-- Step 4 --}}
                <div class="flex flex-col items-center w-1/4 relative z-10">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-300 text-gray-600 shadow">
                    </div>
                    <p class="mt-3 text-sm font-semibold text-gray-600">Selesai</p>
                </div>

            </div>
        </div>


        {{-- Surat Preview Wrapper (lebar normal seperti awal) --}}
<div class="bg-white shadow-md rounded-xl p-4 sm:p-6 border border-gray-200 w-full">

    {{-- Header Surat --}}
    <h2 class="text-xl font-semibold text-gray-900 mb-6 tracking-tight">
        Nama Template Surat
    </h2>

    {{-- Konten Surat --}}
    <div class="border border-gray-300 p-5 sm:p-8 text-[13px] leading-relaxed rounded-lg bg-gray-50"
         style="min-height: 650px;">

        <div class="text-center mb-6">
            <p class="text-base font-bold">PEMERINTAH KOTA</p>
                KELURAHAN EXAMPLE
            </p>
            <p class="font-semibold mt-4 tracking-wide text-sm">PENGANTAR SKCK</p>
            <p class="text-sm">No : <span class="italic text-gray-500">[Akan diisi oleh admin]</span></p>
        </div>

        <p class="mt-6 mb-4 indent-6">
            Yang bertanda tangan di bawah ini Lurah Example, menerangkan bahwa:
        </p>

        <div class="pl-6 space-y-2 text-sm">
            <div class="flex"><span class="w-40">Nama Lengkap</span><span class="w-3">:</span><span class="font-medium">Budi Santoso</span></div>
            <div class="flex"><span class="w-40">NIK</span><span class="w-3">:</span><span>3201234567890123</span></div>
            <div class="flex"><span class="w-40">Alamat Lengkap</span><span class="w-3">:</span><span>Jl. Merdeka No. 123, RT 01/RW 02</span></div>
            <div class="flex"><span class="w-40">No. HP</span><span class="w-3">:</span><span>081234567890</span></div>
            <div class="flex"><span class="w-40">No. Kartu Keluarga</span><span class="w-3">:</span><span>1212121212122</span></div>
            <div class="flex"><span class="w-40">Pekerjaan</span><span class="w-3">:</span><span>Bisnis</span></div>
            <div class="flex"><span class="w-40">Keperluan</span><span class="w-3">:</span><span>Usaha Baru</span></div>
        </div>

        <p class="mt-8 mb-14 leading-relaxed text-sm">
            Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
        </p>

        {{-- Tanda Tangan --}}
        <div class="flex justify-end">
            <div class="w-1/2 text-center text-sm">
                <p>Yogyakarta, 25 November 2025</p>
                <p class="mt-14 font-semibold">Lurah Example</p>
                <p class="italic">[Nama Lurah]</p>
            </div>
        </div>

    </div>

</div>



   

    </div>
@endsection
