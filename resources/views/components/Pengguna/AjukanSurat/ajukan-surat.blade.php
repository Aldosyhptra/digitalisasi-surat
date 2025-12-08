@extends('layouts.pengajuan_surat')

@section('content')

    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

        {{-- Alert --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        {{-- Search & Filter Card --}}
        <div
            class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm
                flex flex-col md:flex-row items-start md:items-center gap-4">

            {{-- Search --}}
            <input type="text" id="searchInput" placeholder="Cari surat..."
                class="flex-1 px-4 py-3 border border-gray-300 rounded-xl text-sm
                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none
                   h-[48px]">

            {{-- Filter by Category --}}
            <select id="filterSelect"
                class="px-4 py-3 border border-gray-300 rounded-xl text-sm
                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none
                   h-[48px]">
                <option value="">Semua Kategori</option>
                <option value="sktm">SKTM</option>
                <option value="domisili">Domisili</option>
                <option value="usaha">Usaha</option>
                <option value="lainnya">Lainnya</option>
            </select>

        </div>

        {{-- Cards dari Database --}}
        <div id="cardsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            @forelse($jenisSuratList as $jenis)
                <div class="card bg-white rounded-xl shadow-md p-5 flex flex-col justify-between hover:shadow-lg transition text-left"
                    data-title="{{ strtolower($jenis->nama_surat) }}" data-category="{{ $jenis->jenis ?? 'lainnya' }}">

                    {{-- Icon --}}
                    <div class="flex items-center mb-4">
                        @php
                            $iconConfig = [
                                'sktm' => ['icon' => 'fa-hand-holding-usd', 'color' => 'bg-yellow-100 text-yellow-700'],
                                'domisili' => ['icon' => 'fa-home', 'color' => 'bg-blue-100 text-blue-700'],
                                'usaha' => ['icon' => 'fa-briefcase', 'color' => 'bg-green-100 text-green-700'],
                                'lainnya' => ['icon' => 'fa-file-alt', 'color' => 'bg-purple-100 text-purple-700'],
                            ];
                            $config = $iconConfig[$jenis->jenis ?? 'lainnya'] ?? $iconConfig['lainnya'];
                        @endphp
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center {{ $config['color'] }}">
                            <i class="fa {{ $config['icon'] }} text-2xl"></i>
                        </div>
                    </div>

                    {{-- Title --}}
                    <h3 class="font-semibold text-gray-800 text-lg mb-1">{{ $jenis->nama_surat }}</h3>

                    {{-- Description --}}
                    <p class="text-gray-500 text-sm mb-4">{{ Str::limit($jenis->deskripsi, 60) }}</p>

                    {{-- Field Info --}}
                    <div class="mb-4">
                        <p class="text-xs text-gray-600 font-medium mb-2">
                            <i class="fas fa-list-check mr-1"></i>Field yang diperlukan:
                        </p>
                        <div class="flex flex-wrap gap-1">
                            @if ($jenis->fields && count($jenis->fields) > 0)
                                @foreach (array_slice($jenis->fields, 0, 2) as $field)
                                    <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-0.5 rounded-full">
                                        {{ $field['label'] }}
                                    </span>
                                @endforeach
                                @if (count($jenis->fields) > 2)
                                    <span
                                        class="inline-block bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded-full font-medium">
                                        +{{ count($jenis->fields) - 2 }}
                                    </span>
                                @endif
                            @else
                                <span class="text-xs text-gray-400">Tidak ada field</span>
                            @endif
                        </div>
                    </div>

                    {{-- Button --}}
                    <a href="{{ route('ajukan-surat.form', $jenis->id) }}"
                        class="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center block">
                        <i class="fas fa-arrow-right mr-2"></i>Ajukan Surat
                    </a>

                </div>
            @empty
                {{-- Empty State --}}
                <div class="col-span-4 text-center py-16 bg-white rounded-xl shadow">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg mb-2">Belum Ada Jenis Surat Tersedia</p>
                    <p class="text-gray-400 text-sm">Silakan hubungi admin untuk informasi lebih lanjut</p>
                </div>
            @endforelse
        </div>

        {{-- Info Box --}}
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-blue-900 mb-3">Informasi Penting</h4>
                    <ul class="space-y-2 text-sm text-blue-800">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-600 mr-2 mt-0.5 flex-shrink-0"></i>
                            <span>Pastikan semua data yang diisi sudah benar dan sesuai dengan dokumen asli</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-600 mr-2 mt-0.5 flex-shrink-0"></i>
                            <span>Surat akan diproses oleh admin maksimal 3x24 jam kerja</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-600 mr-2 mt-0.5 flex-shrink-0"></i>
                            <span>Anda akan mendapat notifikasi setelah surat disetujui atau ditolak</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-600 mr-2 mt-0.5 flex-shrink-0"></i>
                            <span>Jika ditolak, Anda dapat mengajukan kembali dengan perbaikan data</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    {{-- Search & Filter Script --}}
    <script>
        const searchInput = document.getElementById('searchInput');
        const filterSelect = document.getElementById('filterSelect');
        const cards = document.querySelectorAll('#cardsContainer .card');

        function filterCards() {
            const searchTerm = searchInput.value.toLowerCase();
            const filterCategory = filterSelect.value.toLowerCase();

            cards.forEach(card => {
                const title = card.getAttribute('data-title');
                const category = card.getAttribute('data-category');

                const matchesSearch = title.includes(searchTerm);
                const matchesFilter = !filterCategory || category === filterCategory;

                card.style.display = (matchesSearch && matchesFilter) ? 'flex' : 'none';
            });
        }

        searchInput.addEventListener('input', filterCards);
        filterSelect.addEventListener('change', filterCards);
    </script>

@endsection
