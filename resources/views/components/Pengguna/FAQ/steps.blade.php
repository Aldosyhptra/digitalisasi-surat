<div class="mb-16 text-center">
    <header class="mb-12">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-3">BANTUAN & PUSAT INFORMASI</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Temukan jawaban atas pertanyaan Anda atau dapatkan panduan menggunakan layanan desa digital.
        </p>
    </header>

    <h2 class="text-2xl font-bold text-gray-800 text-center mb-10">Panduan Langkah Pengajuan Surat</h2>

    <div class="flex flex-wrap justify-center items-start relative">
        @php
            $steps = [
                ['number'=>1,'title'=>'Pilih Template Surat','desc'=>'Pilih salah satu dari 12–20 template yang tersedia','color'=>'bg-blue-600','icon'=>'fas fa-file-alt'],
                ['number'=>2,'title'=>'Isi Data','desc'=>'Form otomatis menyesuaikan template yang dipilih','color'=>'bg-orange-500','icon'=>'fas fa-pencil-alt'],
                ['number'=>3,'title'=>'Preview & Konfirmasi','desc'=>'Cek sebelum kirim, perbaiki jika ada yang salah','color'=>'bg-yellow-400','icon'=>'fas fa-eye'],
                ['number'=>4,'title'=>'Riwayat & Tracking','desc'=>'Pantau proses hingga selesai','color'=>'bg-purple-600','icon'=>'fas fa-history'],
                ['number'=>5,'title'=>'Download','desc'=>'Dokumen siap di-download dan digunakan','color'=>'bg-green-500','icon'=>'fas fa-download'],
            ];
        @endphp

        <div class="flex flex-col md:flex-row justify-center gap-2 md:gap-2 w-full items-center">
            @foreach($steps as $step)
                <div class="flex flex-col items-center w-full md:w-1/5 text-center p-2 relative">
                    <div class="relative flex items-center justify-center w-[80px] h-[80px] mb-3">
                        <div class="absolute inset-0 {{ $step['color'] }} rounded-full flex items-center justify-center">
                            <i class="{{ $step['icon'] }} text-white text-2xl"></i>
                        </div>
                        <span class="absolute text-white text-3xl font-bold z-10 top-[-10px] right-[-10px]">{{ $step['number'] }}</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $step['title'] }}</h3>
                    <p class="text-sm text-gray-500">{{ $step['desc'] }}</p>
                </div>

                @if(!$loop->last)
                    {{-- Desktop --}}
                    <div class="hidden md:flex items-center justify-center w-[50px]">
                        <i class="fas fa-arrow-right text-gray-400 text-3xl"></i>
                    </div>
                    {{-- Mobile --}}
                    <div class="md:hidden flex justify-center w-full py-2">
                        <i class="fas fa-arrow-down text-gray-400 text-3xl"></i>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
