<div class="w-full lg:w-2/3 xl:w-3/4 bg-white shadow-lg rounded-xl p-6">

    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Informasi Profile</h2>

        <button class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg font-medium 
                       hover:bg-blue-700 transition-colors shadow-md">
            <i class="fa-solid fa-pen mr-2"></i>
            Edit Profile
        </button>
    </div>

    {{-- Data Pribadi --}}
    <div class="mb-8">
        <h3 class="flex items-center text-lg font-semibold text-gray-700 mb-4">
            <i class="fa-solid fa-user text-blue-500 w-6 h-6 mr-2"></i>
            Data Pribadi
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">

            <div>
                <label class="block text-sm font-medium text-gray-700">NIK</label>
                <input disabled value="Nik Pengguna"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 bg-gray-50">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input disabled value="Nama Lengkap"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 bg-gray-50">
            </div>

            <div class="relative">
                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <select disabled
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 bg-gray-50 appearance-none">
                    <option>Semua Status</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 top-6 flex items-center px-2 text-gray-700">
                    <i class="fa-solid fa-chevron-down text-sm"></i>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input disabled value="10/05/2004"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 bg-gray-50">
            </div>

        </div>
    </div>

    {{-- Informasi Kontak --}}
    <div class="mb-8">

        <h3 class="flex items-center text-lg font-semibold text-gray-700 mb-4">
            <i class="fa-solid fa-phone text-blue-500 w-6 h-6 mr-2"></i>
            Informasi Kontak
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-4">

            <div>
                <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                <input disabled value="No. Telepon Pengguna"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 bg-gray-50">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input disabled value="Surat@gmail.com"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 bg-gray-50">
            </div>

        </div>

        <label class="block text-sm font-medium text-gray-700">Alamat</label>
        <textarea disabled rows="2"
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 bg-gray-50 resize-none">
Jl. Merdeka No. 123, RT 05/RW 02, Kelurahan Sukamaju, Kecamatan Bandung Tengah
</textarea>
    </div>

</div>
