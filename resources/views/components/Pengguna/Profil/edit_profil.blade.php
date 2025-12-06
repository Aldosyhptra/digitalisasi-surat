@extends('layouts.pengajuan_surat')

@section('content')
<div class="w-full mx-auto px-6 py-10">

    {{-- Back Button --}}
    <a href="{{ url()->previous() }}"
       class="inline-flex items-center text-gray-600 hover:text-blue-800 mb-8 text-base transition">
        <span class="text-xl mr-2">←</span> Kembali
    </a>

    {{-- FORM WRAPPER --}}
    <form class="bg-white shadow-lg rounded-3xl p-12 max-w-6xl w-full mx-auto space-y-12 border border-gray-100" id="editProfileForm">

    {{-- Header --}}
    <div class="relative mb-8">
        <span class="absolute top-0 right-0 bg-blue-500 text-white px-4 py-1.5 rounded-full text-sm font-semibold">
            Edit Profil
        </span>
        <h2 class="text-3xl font-bold text-gray-900">Profil Saya</h2>
        <hr class="mt-4 border-gray-200">
    </div>

    {{-- DATA PRIBADI --}}
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Data Pribadi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">NIK</label>
                <input name="nik" type="text" value="{{ auth()->user()->nik ?? '' }}" 
                       class="w-full h-14 px-5 border border-gray-300 rounded-2xl text-base focus:ring-2 focus:ring-blue-200 focus:border-blue-500 shadow-sm">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Nama Lengkap</label>
                <input name="nama_lengkap" type="text" value="{{ auth()->user()->name ?? '' }}"
                       class="w-full h-14 px-5 border border-gray-300 rounded-2xl text-base focus:ring-2 focus:ring-blue-200 focus:border-blue-500 shadow-sm">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Tanggal Lahir</label>
                <input name="tgl_lahir" type="date" value="{{ auth()->user()->tgl_lahir ?? '' }}"
                       class="w-full h-14 px-5 border border-gray-300 rounded-2xl text-base focus:ring-2 focus:ring-blue-200 focus:border-blue-500 shadow-sm">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full h-14 px-5 border border-gray-300 rounded-2xl text-base focus:ring-2 focus:ring-blue-200 focus:border-blue-500 shadow-sm">
                    <option value="Laki-laki" {{ (auth()->user()->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ (auth()->user()->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
        </div>
    </div>

    {{-- INFORMASI KONTAK --}}
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Informasi Kontak</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Email</label>
                <input name="email" type="email" value="{{ auth()->user()->email ?? '' }}"
                       class="w-full h-14 px-5 border border-gray-300 rounded-2xl text-base focus:ring-2 focus:ring-blue-200 focus:border-blue-500 shadow-sm">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">No. Telepon</label>
                <input name="telepon" type="text" value="{{ auth()->user()->telepon ?? '' }}"
                       class="w-full h-14 px-5 border border-gray-300 rounded-2xl text-base focus:ring-2 focus:ring-blue-200 focus:border-blue-500 shadow-sm">
            </div>
        </div>
        <div class="mt-6">
            <label class="text-sm font-medium text-gray-700 mb-2 block">Alamat</label>
            <textarea name="alamat" rows="3"
                      class="w-full border border-gray-300 rounded-2xl p-5 text-base focus:ring-2 focus:ring-blue-200 focus:border-blue-500 resize-none shadow-sm">{{ auth()->user()->alamat ?? '' }}</textarea>
        </div>
    </div>

    {{-- FOTO / FILE PROFIL --}}
    <div x-data="{ fileName: '' }">
        <label class="text-sm font-medium text-gray-700 mb-2 block">Upload Foto Profil</label>
        <input type="file" id="file-upload" name="foto" accept=".jpg,.jpeg,.png" class="hidden" @change="fileName = $event.target.files[0]?.name">
        <label for="file-upload" class="mt-3 border-2 border-dashed border-gray-300 rounded-2xl p-10 text-center hover:border-blue-400 hover:bg-gray-50 transition cursor-pointer flex flex-col items-center justify-center">
            <i class="fa-solid fa-upload text-4xl text-gray-400 mb-3"></i>
            <p class="text-gray-600 text-base mb-1">Pilih file atau tarik ke sini</p>
            <p class="text-sm text-gray-500 mb-2">JPG, PNG • Maks 5MB</p>
            <span class="bg-gray-200 px-6 py-3 rounded-full text-sm hover:bg-gray-300">Select File</span>
            <template x-if="fileName">
                <p class="mt-3 text-sm text-green-600 font-medium">File dipilih: <span x-text="fileName"></span></p>
            </template>
        </label>
    </div>

    {{-- ACTION BUTTONS --}}
    <div class="flex justify-end items-center pt-6 gap-4">
        <button type="reset" class="flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 text-base hover:bg-gray-100 transition shadow-sm">
            <i class="fa-solid fa-rotate-left"></i>
            <span>Reset</span>
        </button>

        <button type="submit" class="flex items-center gap-2 px-8 py-3 rounded-xl bg-blue-600 text-white text-base hover:bg-blue-700 transition shadow-md">
            <i class="fa-solid fa-save text-lg"></i>
            <span>Simpan</span>
        </button>
    </div>

</form>

    
</div>

{{-- SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const form = document.getElementById('editProfileForm');

    form.addEventListener('reset', () => {
        setTimeout(() => {
            document.querySelector('[x-data]').__x.$data.fileName = '';
        }, 10);
    });

    form.addEventListener('submit', function(e){
        e.preventDefault();

        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Perubahan profil telah disimpan!',
            confirmButtonText: 'OK',
            customClass: { popup: 'p-7 rounded-2xl' }
        }).then(() => {
            window.location.href = '{{ route("profil.saya") }}';
        });
    });
</script>
@endsection
