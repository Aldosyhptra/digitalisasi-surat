<div class="mb-10 text-center">
    <header class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-1">
            BANTUAN & PUSAT INFORMASI
        </h1>
        <p class="text-base text-gray-600 max-w-xl mx-auto">
            Temukan panduan penggunaan layanan desa digital.
        </p>
    </header>

    <h2 class="text-xl font-bold text-gray-800 text-center mb-4">
        Panduan Langkah Pengajuan Surat
    </h2>

    <div class="flex flex-wrap justify-center items-start relative">

        @php
            $steps = [
                ['number'=>1,'title'=>'Pilih Template Surat','desc'=>'Pilih salah satu dari 12–20 template yang tersedia','color'=>'bg-blue-600'],
                ['number'=>2,'title'=>'Isi Data','desc'=>'Form otomatis menyesuaikan template pilihan','color'=>'bg-orange-500'],
                ['number'=>3,'title'=>'Preview & Konfirmasi','desc'=>'Periksa kembali sebelum mengirim','color'=>'bg-yellow-400'],
                ['number'=>4,'title'=>'Riwayat & Tracking','desc'=>'Pantau proses hingga selesai','color'=>'bg-purple-600'],
                ['number'=>5,'title'=>'Download','desc'=>'Dokumen siap diunduh dan digunakan','color'=>'bg-green-500'],
            ];
        @endphp

        <div class="flex flex-col md:flex-row justify-center gap-1 md:gap-1 w-full items-center">

            @foreach($steps as $step)
                <div class="flex flex-col items-center w-full md:w-1/5 text-center p-1 relative">

                    {{-- ANGKA --}}
                    <div class="relative flex items-center justify-center w-[55px] h-[55px] mb-1">
                        <div class="absolute inset-0 {{ $step['color'] }} rounded-full flex items-center justify-center">
                            <span class="text-white text-xl font-bold">
                                {{ $step['number'] }}
                            </span>
                        </div>
                    </div>

                    {{-- TITLE --}}
                    <h3 class="text-sm font-semibold text-gray-800 mb-1">
                        {{ $step['title'] }}
                    </h3>

                    {{-- DESKRIPSI --}}
                    <p class="text-xs text-gray-500 leading-snug">
                        {{ $step['desc'] }}
                    </p>
                </div>

                {{-- PANAH --}}
                @if(!$loop->last)
                    {{-- Desktop --}}
                    <div class="hidden md:flex items-center justify-center w-[15px]">
                        <i class="fas fa-arrow-right text-gray-300 text-lg"></i>
                    </div>

                    {{-- Mobile --}}
                    <div class="md:hidden flex justify-center w-full py-1">
                        <i class="fas fa-arrow-down text-gray-300 text-lg"></i>
                    </div>
                @endif
            @endforeach

        </div>
    </div>
</div>
