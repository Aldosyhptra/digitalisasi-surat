<div class="bg-white shadow-lg rounded-2xl p-5 w-full">

    {{-- Judul --}}
    <h2 class="text-xl font-semibold text-gray-700 mb-3">Permohonan Terbaru</h2>

    <hr class="mb-4 border-gray-300">

    {{-- Container table --}}
    <div class="w-full overflow-x-auto">

        <div class="min-w-[900px]">

            {{-- Header --}}
            <div class="grid grid-cols-5 gap-3 text-gray-600 text-[15px] font-semibold mb-3 px-1">
                <p>Nama Penduduk</p>
                <p>NIK</p>
                <p>Jenis Surat</p>
                <p>Status</p>
                <p class="text-center">Aksi</p>
            </div>

            {{-- List Data --}}
            <div class="space-y-3 text-[14px] text-gray-700">

                {{-- Item 1 --}}
                <div class="grid grid-cols-5 gap-3 items-center bg-gray-50 p-3 rounded-xl">
                    <p>Siti Rahayu</p>
                    <p>2323283823283</p>
                    <p>Surat Domisili</p>
                    <div class="rounded-lg px-3 py-1 bg-blue-100 text-blue-800 font-semibold text-center w-fit">
                        Baru
                    </div>
                    <a href="#" class="text-blue-600 font-semibold hover:underline text-center">Lihat & Proses</a>
                </div>

                {{-- Item 2 --}}
                <div class="grid grid-cols-5 gap-3 items-center bg-gray-50 p-3 rounded-xl">
                    <p>Budi Santoso</p>
                    <p>2932839293923</p>
                    <p>Pengantar SKCK</p>
                    <div class="rounded-lg px-3 py-1 bg-yellow-100 text-yellow-800 font-semibold text-center w-fit">
                        Proses
                    </div>
                    <a href="#" class="text-blue-600 font-semibold hover:underline text-center">Lihat & Proses</a>
                </div>

                {{-- Item 3 --}}
                <div class="grid grid-cols-5 gap-3 items-center bg-gray-50 p-3 rounded-xl">
                    <p>Dewi Lestari</p>
                    <p>30293929392992</p>
                    <p>Surat Usaha</p>
                    <div class="rounded-lg px-3 py-1 bg-green-100 text-green-800 font-semibold text-center w-fit">
                        Selesai
                    </div>
                    <a href="#" class="text-blue-600 font-semibold hover:underline text-center">Lihat & Proses</a>
                </div>

            </div>

        </div>
    </div>
</div>
