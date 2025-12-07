@extends('layouts.pengajuan_surat')

@section('content')

@php
    $template = request('template');
@endphp

<div class="w-full mx-auto px-6 py-10">

    {{-- Back --}}
    <a href="{{ url()->previous() }}"
       class="inline-flex items-center text-gray-600 hover:text-blue-800 mb-6 text-base">
        <span class="text-xl mr-2">←</span> Kembali
    </a>

    {{-- FORM WRAPPER --}}
    <form class="bg-white shadow-xl rounded-2xl p-12 max-w-7xl mx-auto space-y-12 border border-gray-200" id="pengajuanForm">

        {{-- Header --}}
        <div class="relative">
            <span class="absolute top-0 right-0 bg-blue-500 text-white px-4 py-1.5 rounded-xl text-sm font-semibold">
                Template Aktif
            </span>

            <h2 class="text-3xl font-bold text-gray-900">
                Form Pengajuan: {{ $template }}
            </h2>

            <hr class="mt-6 border-gray-300">
        </div>

        {{-- DATA PRIBADI --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-800 mb-5">Data Pribadi</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1 block">NIK</label>
                    <input name="nik" type="text" class="w-full h-12 px-4 border border-gray-300 rounded-xl text-base focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1 block">Nama Lengkap</label>
                    <input name="nama_lengkap" type="text" class="w-full h-12 px-4 border border-gray-300 rounded-xl text-base focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1 block">NIK Pengguna</label>
                    <input name="nik_pengguna" type="text" class="w-full h-12 px-4 border border-gray-300 rounded-xl text-base focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1 block">Nama Pengguna</label>
                    <input name="nama_pengguna" type="text" class="w-full h-12 px-4 border border-gray-300 rounded-xl text-base focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="mt-6">
                <label class="text-sm font-medium text-gray-700 mb-1 block">Alamat</label>
                <input name="alamat" type="text" class="w-full h-25 px-4 py-3 border border-gray-300 rounded-xl text-base focus:ring-blue-500 focus:border-blue-500" placeholder="Jl. Merdeka No. 123, RT 05/RW 02...">
            </div>
        </div>

        {{-- INFORMASI TAMBAHAN --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-800 mb-5">Informasi Tambahan</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1 block">Pekerjaan</label>
                    <input name="pekerjaan" type="text" class="w-full h-12 px-4 border border-gray-300 rounded-xl text-base focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1 block">No. Telepon</label>
                    <input name="telepon" type="text" class="w-full h-12 px-4 border border-gray-300 rounded-xl text-base focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>

        {{-- KEPERLUAN --}}
        <div>
            <label class="text-sm font-medium text-gray-700 mb-2 block">Keperluan Surat</label>
            <textarea name="keperluan" class="w-full border border-gray-300 rounded-xl p-4 text-base focus:ring-blue-500 focus:border-blue-500" rows="4" placeholder="Jelaskan keperluan Anda"></textarea>
        </div>

        {{-- FILE UPLOAD --}}
        <div x-data="{ fileName: '' }">
            <label class="text-sm font-medium text-gray-700 mb-2 block">Upload Berkas Pendukung</label>

            <input type="file" id="file-upload" name="berkas" accept=".jpg,.jpeg,.png,.pdf" class="hidden" @change="fileName = $event.target.files[0]?.name">

            <label for="file-upload" class="mt-3 border-2 border-dashed border-gray-300 rounded-2xl p-10 text-center hover:border-blue-400 hover:bg-gray-50 transition cursor-pointer block">
                <p class="text-gray-600 text-lg mb-1">Pilih file atau tarik ke sini</p>
                <p class="text-sm text-gray-500 mb-4">JPG, PNG atau PDF • Maks 10MB</p>
                <span class="bg-gray-200 px-6 py-2.5 rounded-xl text-sm hover:bg-gray-300">Select File</span>

                <template x-if="fileName">
                    <p class="mt-4 text-sm text-green-600 font-medium">File dipilih: <span x-text="fileName"></span></p>
                </template>
            </label>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex justify-between items-center pt-6">
            <button type="reset" class="flex items-center gap-3 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 text-base hover:bg-gray-100 transition">
                <i class="fa-solid fa-rotate-left"></i>
                <span>Reset Form</span>
            </button>

            <button type="submit" class="flex items-center gap-3 px-8 py-3 rounded-xl bg-blue-600 text-white text-base hover:bg-blue-700 transition">
                <i class="fa-solid fa-paper-plane text-lg"></i>
                <span>Kirim Pengajuan</span>
            </button>
        </div>

    </form>
</div>

{{-- ==================== SCRIPT ==================== --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const form = document.getElementById('pengajuanForm');

    // Reset file preview
    form.addEventListener('reset', function () {
        setTimeout(() => {
            document.querySelector('[x-data]').__x.$data.fileName = '';
        }, 10);
    });

    // Submit -> SweetAlert info
    form.addEventListener('submit', function(e){
        e.preventDefault();

        const formData = new FormData(form);
        const query = new URLSearchParams();
        formData.forEach((value, key) => {
            if (value) query.append(key, value);
        });

        Swal.fire({
            html: `
                <div class="flex items-start gap-5 text-left">
                    <i class="fas fa-info-circle text-blue-500 text-6xl mt-1"></i>

                    <div>
                        <span class="font-bold text-[22px] leading-tight">Info</span>
                        <p class="text-[15px] leading-[1.45] mt-2">
                            Data formulir telah berhasil diisi.<br>
                            Silakan lakukan pengecekan sebelum mengirim pengajuan.
                        </p>
                    </div>
                </div>
            `,
            showCancelButton: true,

            // Tombol
            confirmButtonText: 'Lihat Detail',
            cancelButtonText: 'Konfirmasi',

            // UI tombol
            customClass: {
                popup: 'p-7 rounded-2xl',
                actions: 'mt-7 flex justify-end gap-3',

                // Lihat Detail = abu
                confirmButton:
                    'px-5 py-2.5 bg-gray-200 text-white-800 rounded-lg hover:bg-gray-300 transition shadow-sm',

                // Konfirmasi = biru
                cancelButton:
                    'px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm',
            }
        }).then((result) => {
            if(result.isConfirmed){
                // Arahkan ke halaman detail_form jika klik Lihat Detail
                window.location.href =
                    '{{ url("pengguna/ajukansurat/detail_form") }}?' + query.toString();
            } else {
                // Jika klik Konfirmasi → langsung ke pengajuan.surat
                window.location.href = '{{ route("pengajuan.surat") }}';
            }
        });
    });
</script>



@endsection
