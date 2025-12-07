{{-- Card Filter --}}
<div class="bg-white p-6 w-full max-w-7xl mx-auto rounded-xl shadow-md border border-gray-100 mb-6">

    {{-- Header & Button --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Manajemen Surat</h2>
        <a href="{{ route('admin.surat.upload_form') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
            <i class="fa fa-plus"></i>
            Upload Template Baru
        </a>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Filter + Search --}}
    <div class="flex flex-wrap gap-6 items-start mb-6">
        <div>
            <label class="text-gray-700 text-sm font-medium mb-1 block">Filter Status</label>
            <select id="filter-status"
                class="w-[223px] h-10 px-3 border border-gray-300 bg-white text-gray-600 text-sm rounded-lg">
                <option value="">Semua Status</option>
                <option value="aktif">Sudah Ada Template</option>
                <option value="tidak_aktif">Belum Ada Template</option>
            </select>
        </div>

        <div>
            <label class="text-gray-700 text-sm font-medium mb-1 block">Filter Jenis Surat</label>
            <select id="filter-jenis"
                class="w-[223px] h-10 px-3 border border-gray-300 bg-white text-gray-600 text-sm rounded-lg">
                <option value="">Semua Jenis</option>
                <option value="sktm">SKTM</option>
                <option value="domisili">Domisili</option>
                <option value="usaha">Usaha</option>
                <option value="lainnya">Lainnya</option>
            </select>
        </div>

        <div class="flex-1 min-w-[250px]">
            <label class="text-gray-700 text-sm font-medium mb-1 block">Pencarian</label>
            <div class="relative h-10">
                <input type="text" id="search" placeholder="Cari Berdasarkan Nama Surat"
                    class="w-full h-full pl-10 pr-3 border border-gray-300 bg-white text-gray-600 text-sm rounded-lg">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fa fa-search text-gray-500"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Cards Grid --}}
<div id="cards-grid"
    class="w-full max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse($jenisSuratList as $jenis)
        <div class="bg-white p-4 border border-gray-200 rounded-lg shadow-sm flex flex-col justify-between h-full relative card-item"
            data-status="{{ $jenis->template_file ? 'aktif' : 'tidak_aktif' }}"
            data-jenis="{{ $jenis->jenis ?? 'lainnya' }}" data-title="{{ strtolower($jenis->nama_surat) }}">

            {{-- Edit/Delete kanan atas --}}
            <div class="absolute top-2 right-2 flex space-x-3">
                @if ($jenis->template_file)
                    <form action="{{ route('admin.surat.hapus', $jenis->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin hapus template ini?')"
                            class="text-gray-400 hover:text-red-500 p-2 text-lg" title="Hapus Template">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                @endif
            </div>

            {{-- Icon kiri atas berdasarkan jenis --}}
            <div class="flex justify-start mb-3">
                @php
                    $iconConfig = [
                        'sktm' => [
                            'icon' => 'fa-hand-holding-usd',
                            'bg' => 'bg-yellow-100',
                            'color' => 'text-yellow-600',
                        ],
                        'domisili' => ['icon' => 'fa-home', 'bg' => 'bg-green-100', 'color' => 'text-green-600'],
                        'usaha' => ['icon' => 'fa-briefcase', 'bg' => 'bg-purple-100', 'color' => 'text-purple-600'],
                        'lainnya' => ['icon' => 'fa-file-alt', 'bg' => 'bg-blue-100', 'color' => 'text-blue-600'],
                    ];
                    $config = $iconConfig[$jenis->jenis ?? 'lainnya'] ?? $iconConfig['lainnya'];
                @endphp
                <div class="{{ $config['bg'] }} p-3 rounded-lg inline-flex items-center justify-center">
                    <i class="fa {{ $config['icon'] }} {{ $config['color'] }} text-lg"></i>
                </div>
            </div>

            {{-- Judul + Deskripsi --}}
            <div class="mb-4">
                <h3 class="text-base font-semibold text-gray-800">{{ $jenis->nama_surat }}</h3>
                <p class="text-xs text-gray-500 mt-1">{{ $jenis->deskripsi }}</p>
            </div>

            {{-- Fields --}}
            <div class="mb-4">
                <span class="font-medium text-gray-600 text-xs">Field yang digunakan:</span>
                <div class="mt-1 flex flex-wrap gap-1">
                    @if ($jenis->fields && count($jenis->fields) > 0)
                        @foreach (array_slice($jenis->fields, 0, 3) as $field)
                            <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-0.5 rounded-full">
                                {{ $field['label'] }}
                            </span>
                        @endforeach
                        @if (count($jenis->fields) > 3)
                            <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-0.5 rounded-full">
                                +{{ count($jenis->fields) - 3 }} Lainnya
                            </span>
                        @endif
                    @else
                        <span class="text-xs text-gray-400">Belum ada field</span>
                    @endif
                </div>
            </div>

            {{-- Footer Status --}}
            <div class="mt-auto">
                @if ($jenis->template_file)
                    <button
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 rounded-lg transition">
                        Template Tersedia
                    </button>
                @else
                    <a href="{{ route('admin.surat.upload_form') }}"
                        class="block w-full bg-gray-400 hover:bg-gray-500 text-white text-sm font-semibold py-2 rounded-lg transition text-center">
                        Belum Ada Template
                    </a>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-4 text-center py-12 bg-white rounded-xl shadow">
            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 mb-4">Belum ada jenis surat</p>
        </div>
    @endforelse
</div>

<script>
    const filterStatus = document.getElementById('filter-status');
    const filterJenis = document.getElementById('filter-jenis');
    const searchInput = document.getElementById('search');
    const cards = document.querySelectorAll('.card-item');

    function filterCards() {
        const status = filterStatus.value;
        const jenis = filterJenis.value;
        const search = searchInput.value.toLowerCase();

        cards.forEach(card => {
            const cardStatus = card.dataset.status;
            const cardJenis = card.dataset.jenis;
            const cardTitle = card.dataset.title;

            const matchStatus = !status || cardStatus === status;
            const matchJenis = !jenis || cardJenis === jenis;
            const matchSearch = !search || cardTitle.includes(search);

            if (matchStatus && matchJenis && matchSearch) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    filterStatus.addEventListener('change', filterCards);
    filterJenis.addEventListener('change', filterCards);
    searchInput.addEventListener('input', filterCards);
</script>
