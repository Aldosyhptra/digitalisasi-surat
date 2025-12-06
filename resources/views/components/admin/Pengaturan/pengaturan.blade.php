<div class="bg-white shadow-lg rounded-2xl p-4 md:p-6 lg:p-8 w-full my-6">

    {{-- Judul --}}
    <div class="mb-4">
        <h2 class="text-xl md:text-2xl font-semibold text-gray-700">Informasi Kelurahan</h2>
    </div>

    <hr class="mb-6 border-gray-300">

    {{-- Informasi Kelurahan Section --}}
    <div class="mb-8">
        <h3 class="text-base md:text-lg font-medium text-gray-700 mb-4">Informasi Kelurahan</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Nama</label>
                <input type="text"
                       placeholder="Masukkan Nama Kelurahan"
                       class="block w-full px-3 py-2.5 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Alamat</label>
                <input type="text"
                       placeholder="Alamat Lengkap Kelurahan"
                       class="block w-full px-3 py-2.5 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        {{-- Logo Instansi --}}
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-2">Logo Instansi</label>

            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 bg-blue-100 p-3 rounded-xl">
                    <i class="fa-solid fa-building fa-2x text-blue-600"></i>
                </div>

                <label for="upload-logo"
                       class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-5 rounded-xl shadow flex items-center gap-2 text-sm">
                    <i class="fa-solid fa-upload text-sm"></i>
                    <span>Upload Logo</span>
                    <input type="file" id="upload-logo" class="sr-only">
                </label>
            </div>
        </div>
    </div>

    {{-- Informasi Kontak --}}
    <div class="mb-8">
        <h3 class="text-base md:text-lg font-medium text-gray-700 mb-4">Informasi Kontak</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-phone text-gray-500 text-xs"></i> Kontak
                </label>
                <input type="text" value="(+62) 1234-5678-2322"
                       class="block w-full px-3 py-2.5 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-envelope text-gray-500 text-xs"></i> Email
                </label>
                <input type="email" value="kelurahan@example.com"
                       class="block w-full px-3 py-2.5 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fa-solid fa-location-dot text-gray-500 text-xs"></i> Lokasi
                </label>
                <input type="text" value="JL. kelurahan, RT 05, RW 20"
                       class="block w-full px-3 py-2.5 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

        </div>
    </div>

    {{-- Jam Operasional --}}
    <div class="mb-8">
        <h3 class="text-base md:text-lg font-medium text-gray-700 mb-4">Jam Operasional</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Senin - Jumat</label>
                <input type="text" value="08:00 - 16:00 WIB"
                       class="block w-full px-3 py-2.5 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Sabtu</label>
                <input type="text" value="08:00 - 12:00 WIB"
                       class="block w-full px-3 py-2.5 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Minggu</label>
                <input type="text" value="Tutup"
                       class="block w-full px-3 py-2.5 border border-gray-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

        </div>
    </div>

    {{-- Simpan --}}
    <div class="mt-6">
        <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-7 rounded-xl shadow-md text-sm">
            Simpan Perubahan
        </button>
    </div>

</div>
