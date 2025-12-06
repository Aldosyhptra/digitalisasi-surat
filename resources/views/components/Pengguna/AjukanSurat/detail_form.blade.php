@extends('layouts.pengajuan_surat')

@section('content')

@php
    $data = $data ?? request()->all();
@endphp

<div class="w-full px-6 py-10">

    {{-- Back --}}
    <a href="{{ url()->previous() }}"
        class="inline-flex items-center text-gray-600 hover:text-blue-800 mb-6 text-sm md:text-base">
        <span class="text-xl mr-2">←</span> Kembali
    </a>

    {{-- SURAT WRAPPER --}}
    <div class="bg-white shadow-md rounded-2xl p-8 md:p-12 w-full max-w-5xl mx-auto border border-gray-200 space-y-6">

        {{-- Header --}}
        <div class="text-center mb-6 leading-tight">
            <h1 class="text-2xl font-bold tracking-wide">Nama Template Surat</h1>

            <p class="text-xs font-semibold mt-2">PEMERINTAH KOTA</p>
            <p class="text-xs font-semibold">KELURAHAN EXAMPLE</p>

            <h2 class="text-lg md:text-xl font-bold mt-4 tracking-wide">PENGANTAR SKCK</h2>
            <p class="text-[13px] text-gray-600">No: [Akan diisi oleh admin]</p>

            <hr class="mt-4 border-gray-300">
        </div>

        {{-- Pembuka --}}
        <p class="text-[15px] leading-relaxed">
            Yang bertanda tangan di bawah ini Lurah Example, menerangkan bahwa:
        </p>

        {{-- DATA PRIBADI --}}
        <div class="space-y-2 text-[15px] leading-relaxed mt-4">
            <p><span class="font-semibold">Nama Lengkap:</span> {{ $data['nama_lengkap'] ?? 'Budi Santoso' }}</p>
            <p><span class="font-semibold">NIK:</span> {{ $data['nik'] ?? '3201234567890123' }}</p>
            <p><span class="font-semibold">Alamat Lengkap:</span> {{ $data['alamat'] ?? 'Jl. Merdeka No. 123, RT 01/RW 02' }}</p>
            <p><span class="font-semibold">No. HP:</span> {{ $data['telepon'] ?? '081234567890' }}</p>
            <p><span class="font-semibold">No. Kartu Keluarga:</span> {{ $data['no_kk'] ?? '12121212122' }}</p>
            <p><span class="font-semibold">Pekerjaan:</span> {{ $data['pekerjaan'] ?? 'bisnis' }}</p>
            <p><span class="font-semibold">Keperluan:</span> {{ $data['keperluan'] ?? 'usaha baru' }}</p>
        </div>

        {{-- Penutup Surat --}}
        <p class="mt-6 text-[15px] leading-relaxed">
            Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
        </p>

        {{-- Tanda Tangan --}}
        <div class="mt-10 flex justify-end">
            <div class="text-center text-[15px] leading-relaxed">
                <p>Yogyakarta, 25 November 2025</p>
                <p class="mt-10 font-semibold">Lurah Example</p>
                <p>[Nama Lurah]</p>
            </div>
        </div>

    </div>

    {{-- ACTION BUTTONS --}}
    <div class="w-full max-w-5xl mx-auto flex justify-between mt-8 px-1 md:px-0">

        {{-- Edit Form --}}
        <a href="{{ url()->previous() }}"
            class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition text-sm md:text-base">
            Edit Form
        </a>

        {{-- Kirim Pengajuan --}}
        <button id="konfirmasiBtn"
            class="px-8 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition text-sm md:text-base">
            Kirim Pengajuan
        </button>

    </div>

</div>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('konfirmasiBtn').addEventListener('click', function () {
    Swal.fire({
        showConfirmButton: true,
        showCancelButton: true,

        confirmButtonText: 'Konfirmasi',
        cancelButtonText: 'Batal',
        reverseButtons: true, // Konfirmasi di kanan

        buttonsStyling: false,
        customClass: {
            popup: 'rounded-2xl p-7',
            actions: 'mt-6 flex justify-end gap-3',

            // Confirm (biru)
            confirmButton:
                'px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm',

            // Cancel (abu)
            cancelButton:
                'px-6 py-2.5 rounded-lg bg-gray-200 text-gray-800 hover:bg-gray-300 transition shadow-sm'
        },

        html: `
            <div class="flex items-start gap-5 text-left">

                <!-- ICON SUCCESS -->
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 text-6xl"></i>
                </div>

                <!-- TEKS -->
                <div>
                    <p class="text-[20px] font-semibold text-gray-900">Success</p>

                    <p class="text-[15px] text-gray-700 mt-2 leading-relaxed">
                        Silakan klik <span class="font-semibold">‘Konfirmasi’</span>
                        untuk mengirim pengajuan.
                    </p>
                </div>

            </div>
        `
    }).then((result) => {
        if (result.isConfirmed) {
            // Klik Konfirmasi -> ke route pengajuan.surat
            window.location.href = "{{ route('pengajuan.surat') }}";
        }
    });
});
</script>



@endsection
