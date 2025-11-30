<div class="bg-white shadow-lg rounded-2xl p-6 md:p-12 lg:p-16 w-full my-8">

    {{-- Judul --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl md:text-3xl font-semibold text-gray-700">Informasi Kelurahan</h2>
    </div>
    <hr class="mb-8 border-gray-300">

    {{-- Informasi Kelurahan Section --}}
    <div class="mb-8">
        <h3 class="text-lg md:text-xl font-medium text-gray-700 mb-6">Informasi Kelurahan</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="nama-kelurahan" class="block text-sm md:text-base font-medium text-gray-700 mb-2">Nama</label>
                <input type="text" id="nama-kelurahan" placeholder="Masukkan Nama Kelurahan"
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm md:text-base">
            </div>
            <div>
                <label for="alamat-kelurahan" class="block text-sm md:text-base font-medium text-gray-700 mb-2">Alamat</label>
                <input type="text" id="alamat-kelurahan" placeholder="Alamat Lengkap Kelurahan"
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm md:text-base">
            </div>
        </div>

        {{-- Logo Instansi --}}
        <div>
            <label class="block text-sm md:text-base font-medium text-gray-700 mb-3">Logo Instansi</label>
            <div class="flex items-center gap-5">
                <div class="flex-shrink-0 bg-blue-100 p-4 rounded-xl">
                    <i class="fa-solid fa-building fa-3x text-blue-600"></i>
                </div>
                <label for="upload-logo" class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-xl shadow-md flex items-center gap-3 md:text-base">
                    <i class="fa-solid fa-upload"></i>
                    <span>Upload Logo</span>
                    <input type="file" id="upload-logo" class="sr-only">
                </label>
            </div>
        </div>
    </div>

    {{-- Informasi Kontak Section --}}
    <div class="mb-8">
        <h3 class="text-lg md:text-xl font-medium text-gray-700 mb-6">Informasi Kontak</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="kontak" class="block text-sm md:text-base font-medium text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fa-solid fa-phone fa-sm text-gray-500"></i> Kontak
                </label>
                <input type="text" id="kontak" value="(+62) 1234-5678-2322"
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm md:text-base">
            </div>
            <div>
                <label for="email" class="block text-sm md:text-base font-medium text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fa-solid fa-envelope fa-sm text-gray-500"></i> Email
                </label>
                <input type="email" id="email" value="kelurahan@example.com"
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm md:text-base">
            </div>
            <div>
                <label for="lokasi" class="block text-sm md:text-base font-medium text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fa-solid fa-location-dot fa-sm text-gray-500"></i> Lokasi
                </label>
                <input type="text" id="lokasi" value="JL. kelurahan, RT 05, RW 20"
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm md:text-base">
            </div>
        </div>
    </div>

    {{-- Jam Operasional Section --}}
    <div class="mb-8">
        <h3 class="text-lg md:text-xl font-medium text-gray-700 mb-6">Jam Operasional</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="senin-jumat" class="block text-sm md:text-base font-medium text-gray-700 mb-2">Senin - Jumat</label>
                <input type="text" id="senin-jumat" value="08:00 - 16:00 WIB"
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm md:text-base">
            </div>
            <div>
                <label for="sabtu" class="block text-sm md:text-base font-medium text-gray-700 mb-2">Sabtu</label>
                <input type="text" id="sabtu" value="08:00 - 12:00 WIB"
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm md:text-base">
            </div>
            <div>
                <label for="minggu" class="block text-sm md:text-base font-medium text-gray-700 mb-2">Minggu</label>
                <input type="text" id="minggu" value="Tutup"
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm md:text-base">
            </div>
        </div>
    </div>

    {{-- Simpan Perubahan Button --}}
    <div class="flex justify-start mt-8">
        <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-xl shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 md:text-base">
            Simpan Perubahan
        </button>
    </div>

</div>
