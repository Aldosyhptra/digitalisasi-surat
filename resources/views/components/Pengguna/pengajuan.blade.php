<div class="bg-white shadow-lg rounded-2xl p-5 w-full">

    {{-- Judul --}}
    <h2 class="text-xl font-semibold text-gray-700 mb-3">Pengajuan Terbaru</h2>

    <hr class="mb-4 border-gray-300">

    {{-- Container table → responsive horizontal --}}
    <div class="w-full overflow-x-auto">

        <div class="min-w-[800px] lg:min-w-[850px]">

            {{-- Header --}}
            <div class="grid grid-cols-4 gap-3 text-gray-600 text-[15px] font-semibold mb-3 px-1">
                <p>Jenis Surat</p>
                <p>Tanggal</p>
                <p>Status</p>
                <p>Aksi</p>
            </div>

            {{-- List Data --}}
            <div class="space-y-3 text-[14px] text-gray-700">

                {{-- Item 1 --}}
                <div class="grid grid-cols-4 gap-3 items-center bg-gray-50 p-3 rounded-xl">
                    <p>Surat Keterangan Domisili</p>
                    <p>12 Nov 2025</p>
                    <div class="rounded-lg px-3 py-1 bg-yellow-100 text-yellow-800 font-semibold text-center w-fit">
                        Verifikasi
                    </div>
                    <a href="#" class="text-blue-600 font-semibold hover:underline">Lihat</a>
                </div>

                {{-- Item 2 --}}
                <div class="grid grid-cols-4 gap-3 items-center bg-gray-50 p-3 rounded-xl">
                    <p>Surat Pengantar SKCK</p>
                    <p>14 Nov 2025</p>
                    <div class="rounded-lg px-3 py-1 bg-orange-100 text-orange-800 font-semibold text-center w-fit">
                        Proses
                    </div>
                    <a href="#" class="text-blue-600 font-semibold hover:underline">Lihat</a>
                </div>

                {{-- Item 3 --}}
                <div class="grid grid-cols-4 gap-3 items-center bg-gray-50 p-3 rounded-xl">
                    <p>Surat Keterangan Usaha</p>
                    <p>18 Nov 2025</p>
                    <div class="rounded-lg px-3 py-1 bg-green-100 text-green-800 font-semibold text-center w-fit">
                        Selesai
                    </div>
                    <div class="flex gap-3">
                        <a href="#" class="text-blue-600 font-semibold hover:underline">Lihat</a>
                        <a href="#" class="text-green-600 font-semibold hover:underline">Download</a>
                    </div>
                </div>

                {{-- Item 4 --}}
                <div class="grid grid-cols-4 gap-3 items-center bg-gray-50 p-3 rounded-xl">
                    <p>Surat Izin Usaha Mikro</p>
                    <p>20 Nov 2025</p>
                    <div class="rounded-lg px-3 py-1 bg-blue-100 text-blue-800 font-semibold text-center w-fit">
                        Selesai
                    </div>
                    <a href="#" class="text-blue-600 font-semibold hover:underline">Lihat</a>
                </div>

                {{-- Item 5 --}}
                <div class="grid grid-cols-4 gap-3 items-center bg-gray-50 p-3 rounded-xl">
                    <p>Surat Keterangan Tidak Mampu</p>
                    <p>22 Nov 2025</p>
                    <div class="rounded-lg px-3 py-1 bg-green-100 text-green-800 font-semibold text-center w-fit">
                        Selesai
                    </div>
                    <a href="#" class="text-blue-600 font-semibold hover:underline">Lihat</a>
                </div>

            </div>
        </div>
    </div>
</div>
