@extends('layouts.pengajuan_surat')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

    {{-- Search & Filter Card --}}
    <div class="bg-white shadow-md rounded-xl p-6 flex flex-col md:flex-row items-start md:items-center gap-4">
        <input type="text" id="searchInput" placeholder="Cari surat..." 
               class="flex-1 px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
        <select id="filterSelect" class="px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
            <option value="">Semua Jenis Surat</option>
            <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
            <option value="Surat Pengantar SKCK">Surat Pengantar SKCK</option>
            <option value="Surat Keterangan Usaha">Surat Keterangan Usaha</option>
            <option value="Surat Izin Keramaian">Surat Izin Keramaian</option>
            <option value="Surat Keterangan Tidak Mampu">Surat Keterangan Tidak Mampu</option>
            <option value="Surat Izin Usaha Mikro">Surat Izin Usaha Mikro</option>
            <option value="Surat Keterangan Sehat">Surat Keterangan Sehat</option>
            <option value="Surat Pindah">Surat Pindah</option>
            <option value="Surat Kelahiran">Surat Kelahiran</option>
            <option value="Surat Kematian">Surat Kematian</option>
            <option value="Surat Domisili Usaha">Surat Domisili Usaha</option>
            <option value="Surat Pernyataan">Surat Pernyataan</option>
        </select>
    </div>

    {{-- Card Grid 4x3 --}}
    <div id="cardsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $cards = [
                ['title' => 'Surat Keterangan Domisili', 'desc' => 'Keterangan domisili', 'icon' => 'fa-home', 'color' => 'bg-blue-100 text-blue-700'],
                ['title' => 'Surat Pengantar SKCK', 'desc' => 'Pengantar SKCK', 'icon' => 'fa-file-alt', 'color' => 'bg-yellow-100 text-yellow-700'],
                ['title' => 'Surat Keterangan Usaha', 'desc' => 'Keterangan usaha', 'icon' => 'fa-copy', 'color' => 'bg-green-100 text-green-700'],
                ['title' => 'Surat Izin Keramaian', 'desc' => 'Izin keramaian', 'icon' => 'fa-flag', 'color' => 'bg-purple-100 text-purple-700'],
                ['title' => 'Surat Keterangan Tidak Mampu', 'desc' => 'Keterangan tidak mampu', 'icon' => 'fa-user', 'color' => 'bg-red-100 text-red-700'],
                ['title' => 'Surat Izin Usaha Mikro', 'desc' => 'Izin usaha mikro', 'icon' => 'fa-briefcase', 'color' => 'bg-indigo-100 text-indigo-700'],
                ['title' => 'Surat Keterangan Sehat', 'desc' => 'Keterangan sehat', 'icon' => 'fa-heartbeat', 'color' => 'bg-pink-100 text-pink-700'],
                ['title' => 'Surat Pindah', 'desc' => 'Keterangan pindah', 'icon' => 'fa-map-marker-alt', 'color' => 'bg-teal-100 text-teal-700'],
                ['title' => 'Surat Kelahiran', 'desc' => 'Keterangan lahir', 'icon' => 'fa-baby', 'color' => 'bg-orange-100 text-orange-700'],
                ['title' => 'Surat Kematian', 'desc' => 'Keterangan meninggal', 'icon' => 'fa-skull', 'color' => 'bg-gray-100 text-gray-700'],
                ['title' => 'Surat Domisili Usaha', 'desc' => 'Domisili usaha', 'icon' => 'fa-building', 'color' => 'bg-blue-200 text-blue-800'],
                ['title' => 'Surat Pernyataan', 'desc' => 'Pernyataan resmi', 'icon' => 'fa-file-signature', 'color' => 'bg-green-200 text-green-800'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="card bg-white rounded-xl shadow-md p-5 flex flex-col justify-between hover:shadow-lg transition text-left"
             data-title="{{ $card['title'] }}">
            
            {{-- Icon --}}
            <div class="flex items-center mb-4">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center {{ $card['color'] }}">
                    <i class="fa {{ $card['icon'] }} text-2xl"></i>
                </div>
            </div>

            {{-- Title --}}
            <h3 class="font-semibold text-gray-800 text-lg mb-1">{{ $card['title'] }}</h3>

            {{-- Description --}}
            <p class="text-gray-500 text-sm mb-4">{{ $card['desc'] }}</p>

            {{-- Button --}}
            <button class="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Pilih Template
            </button>
        </div>
        @endforeach
    </div>

</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const filterSelect = document.getElementById('filterSelect');
    const cards = document.querySelectorAll('#cardsContainer .card');

    function filterCards() {
        const searchTerm = searchInput.value.toLowerCase();
        const filterTerm = filterSelect.value.toLowerCase();

        cards.forEach(card => {
            const title = card.getAttribute('data-title').toLowerCase();
            const matchesSearch = title.includes(searchTerm);
            const matchesFilter = !filterTerm || title === filterTerm;

            if (matchesSearch && matchesFilter) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterCards);
    filterSelect.addEventListener('change', filterCards);
</script>

@endsection
