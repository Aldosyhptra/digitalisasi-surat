@extends('layouts.pengajuan_surat')

@section('content')
    <div class="w-full mx-auto px-6 py-10">

        {{-- Back Button --}}
        <a href="{{ url()->previous() }}"
            class="inline-flex items-center text-gray-600 hover:text-blue-800 mb-8 text-base transition">
            <span class="text-xl mr-2">←</span> Kembali
        </a>

        <form class="bg-white shadow-lg rounded-3xl p-12 max-w-6xl w-full mx-auto space-y-12 border border-gray-100"
            id="editProfileForm" action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

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

                    {{-- NIK --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">NIK</label>
                        <input name="nik" type="text" value="{{ auth()->user()->nik }}"
                            class="w-full h-14 px-5 border border-gray-300 rounded-2xl text-base">
                    </div>

                    {{-- NAMA --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Nama Lengkap</label>
                        <input name="nama" type="text" value="{{ auth()->user()->nama }}"
                            class="w-full h-14 px-5 border border-gray-300 rounded-2xl text-base">
                    </div>

                    {{-- JENIS KELAMIN --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full h-14 px-5 border border-gray-300 rounded-2xl text-base">
                            <option value="">-- Pilih --</option>
                            <option value="laki-laki" {{ auth()->user()->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>
                                Laki-Laki
                            </option>
                            <option value="perempuan" {{ auth()->user()->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                    </div>

                    {{-- TANGGAL LAHIR --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Tanggal Lahir</label>
                        <input name="tanggal_lahir" type="date" value="{{ auth()->user()->tanggal_lahir }}"
                            class="w-full h-14 px-5 border border-gray-300 rounded-2xl text-base">
                    </div>

                    {{-- USERNAME --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Username</label>
                        <input name="username" type="text" value="{{ auth()->user()->username }}"
                            class="w-full h-14 px-5 border border-gray-300 rounded-2xl text-base">
                    </div>

                    {{-- ALAMAT --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Alamat</label>
                        <textarea name="alamat" rows="3" class="w-full border border-gray-300 rounded-2xl p-5 text-base">{{ auth()->user()->alamat }}</textarea>
                    </div>

                </div>
            </div>

            {{-- INFORMASI KONTAK --}}
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Informasi Kontak</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- NO WA --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">No. WhatsApp</label>
                        <input name="no_wa" type="text" value="{{ auth()->user()->no_wa }}"
                            class="w-full h-14 px-5 border border-gray-300 rounded-2xl text-base">
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Email</label>
                        <input name="email" type="email" value="{{ auth()->user()->email }}"
                            class="w-full h-14 px-5 border border-gray-300 rounded-2xl text-base">
                    </div>

                    {{-- BIO --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Bio</label>
                        <textarea name="bio" rows="3" class="w-full border border-gray-300 rounded-2xl p-5 text-base">{{ auth()->user()->bio }}</textarea>
                    </div>

                </div>
            </div>

            {{-- PASSWORD UPDATE --}}
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Ubah Password (Opsional)</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Password Baru</label>
                        <input name="password" type="password"
                            class="w-full h-14 px-5 border border-gray-300 rounded-2xl text-base">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Konfirmasi Password</label>
                        <input name="password_confirmation" type="password"
                            class="w-full h-14 px-5 border border-gray-300 rounded-2xl text-base">
                    </div>

                </div>
            </div>

            {{-- FOTO PROFIL --}}
            <div x-data="{
                fileName: '',
                previewUrl: '{{ auth()->user()->foto ? asset('storage/foto/' . auth()->user()->foto) : '' }}',
                hasPreview: {{ auth()->user()->foto ? 'true' : 'false' }},
                previewImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.fileName = file.name;
                        this.previewUrl = URL.createObjectURL(file);
                        this.hasPreview = true;
                    }
                },
                removeImage() {
                    this.fileName = '';
                    this.previewUrl = '';
                    this.hasPreview = false;
                    document.getElementById('file-upload').value = '';
                }
            }">
                <label class="text-sm font-medium text-gray-700 mb-2 block">Foto Profil</label>

                {{-- Preview Gambar --}}
                <div x-show="hasPreview" class="mb-4 relative inline-block">
                    <img :src="previewUrl" alt="Preview"
                        class="w-32 h-32 object-cover rounded-full border-4 border-gray-200 shadow-lg">

                    <button type="button" @click="removeImage"
                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600 transition shadow-lg">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>

                {{-- Upload Area - Sembunyikan saat ada preview --}}
                <div x-show="!hasPreview">
                    <input type="file" name="foto" id="file-upload" class="hidden" accept=".jpg,.jpeg,.png"
                        @change="previewImage($event)">

                    <label for="file-upload"
                        class="mt-3 border-2 border-dashed border-gray-300 rounded-2xl p-10 text-center hover:border-blue-400 hover:bg-gray-50 transition cursor-pointer flex flex-col items-center justify-center">

                        <i class="fa-solid fa-upload text-4xl text-gray-400 mb-3"></i>
                        <p class="text-gray-600 text-base mb-1">Pilih file atau tarik ke sini</p>
                        <p class="text-sm text-gray-500 mb-2">JPG, PNG • Maks 2MB</p>

                    </label>
                </div>
            </div>

            {{-- BUTTONS --}}
            <div class="flex justify-end items-center pt-6 gap-4">
                <button type="reset"
                    class="flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 text-base">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>Reset</span>
                </button>

                <button type="submit"
                    class="flex items-center gap-2 px-8 py-3 rounded-xl bg-blue-600 text-white text-base">
                    <i class="fa-solid fa-save text-lg"></i>
                    <span>Simpan</span>
                </button>
            </div>

        </form>

    </div>

    {{-- SCRIPT --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const form = document.getElementById('editProfileForm');

        form.addEventListener('reset', () => {
            setTimeout(() => {
                document.querySelector('[x-data]').__x.$data.fileName = '';
            }, 10);
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Perubahan profil telah disimpan!',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'p-7 rounded-2xl'
                }
            }).then(() => {
                form.submit();
            });
        });
    </script>
@endsection
