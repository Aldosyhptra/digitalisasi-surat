<div class="max-w-6xl mx-auto text-center mb-16">

    {{-- Card Besar --}}
    <div class="bg-white shadow-xl rounded-2xl p-10 border border-gray-200">
           {{-- Judul --}}
           <h2 class="text-2xl font-bold text-gray-800 mb-3">Butuh Bantuan Tambahan?</h2>
           <p class="text-gray-600 mb-10">Tim support kami siap membantu Anda 24/7</p>


        @php
            $supports = [
                [
                    'title'=>'Chat WhatsApp',
                    'desc'=>'Respon cepat melalui WhatsApp',
                    'color'=>'green',
                    'icon'=>'fas fa-comment',
                    'btn'=>'Hubungi Admin',
                    'link'=>'#'
                ],
                [
                    'title'=>'Email Pengaduan',
                    'desc'=>'Kirim email untuk bantuan detail',
                    'color'=>'blue',
                    'icon'=>'fas fa-envelope',
                    'btn'=>'Kirim Email',
                    'link'=>'#'
                ],
                [
                    'title'=>'Kantor Desa',
                    'desc'=>'Senin–Jumat: 08:00–16:00',
                    'color'=>'gray',
                    'icon'=>'fas fa-home',
                    'btn'=>'Lihat Lokasi',
                    'link'=>'#'
                ],
            ];
        @endphp

        {{-- 3 Card Kecil --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-3">

            @foreach($supports as $s)
            <div class="p-5 rounded-xl border border-gray-200 bg-gray-50 shadow-sm 
                        hover:shadow-lg transition-all duration-300 flex flex-col items-center">

                {{-- Icon lingkaran --}}
                <div class="w-14 h-14 flex items-center justify-center rounded-full 
                    bg-{{ $s['color'] }}-100 text-{{ $s['color'] }}-600 text-2xl mb-3
                    transition-all duration-200 hover:bg-{{ $s['color'] }}-600 hover:text-white">
                    <i class="{{ $s['icon'] }}"></i>
                </div>

                {{-- Judul --}}
                <h3 class="font-semibold text-gray-800 mb-1 text-sm">
                    {{ $s['title'] }}
                </h3>

                {{-- Deskripsi --}}
                <p class="text-xs text-gray-600 mb-4 leading-relaxed">
                    {{ $s['desc'] }}
                </p>

                {{-- Button (Khusus Kantor Desa warna custom) --}}
                <a href="{{ $s['link'] }}"
                    class="w-full py-2 rounded-full font-medium text-white text-sm transition
                    @if($s['color'] === 'gray')
                        bg-[#6B7280] hover:bg-[#4B5563]
                    @else
                        bg-{{ $s['color'] }}-600 hover:bg-{{ $s['color'] }}-700
                    @endif
                ">
                    {{ $s['btn'] }}
                </a>

            </div>
            @endforeach

        </div>
    </div>
</div>
