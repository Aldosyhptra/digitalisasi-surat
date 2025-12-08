@extends('layouts.pengajuan_surat')

@section('content')
    {{-- ========================= --}}
    {{--     CDN jsPDF            --}}
    {{-- ========================= --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    {{-- ========================= --}}
    {{-- Filter & Search --}}
    {{-- ========================= --}}
    <div class="bg-white p-6 w-full max-w-7xl mx-auto mb-6">
        <div class="flex flex-wrap gap-6 items-start">

            {{-- Generate Filter --}}
            @php
                $filters = [
                    [
                        'id' => 'filter-status',
                        'label' => 'Filter Status',
                        'options' => [
                            '' => 'Semua Status',
                            'Verifikasi' => 'Verifikasi',
                            'Proses' => 'Proses',
                            'Selesai' => 'Selesai',
                            'Ditolak' => 'Ditolak',
                        ],
                    ],
                    [
                        'id' => 'filter-jenis-surat',
                        'label' => 'Filter Jenis Surat',
                        'options' =>
                            [
                                '' => 'Semua Jenis Surat',
                            ] + $suratList->pluck('jenisSurat.nama', 'jenisSurat.nama')->unique()->toArray(),
                    ],
                ];
            @endphp

            @foreach ($filters as $filter)
                <div>
                    <label for="{{ $filter['id'] }}" class="text-gray-700 text-sm font-medium mb-1 block">
                        {{ $filter['label'] }}
                    </label>
                    <div class="relative w-[223px]">
                        <select id="{{ $filter['id'] }}"
                            class="w-full h-10 px-3 border border-gray-300 bg-white text-gray-600 text-sm rounded-lg appearance-none focus:ring-blue-500 focus:border-blue-500 cursor-pointer">
                            @foreach ($filter['options'] as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>

                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Search --}}
            <div class="flex-1 min-w-[250px]">
                <label for="search" class="text-gray-700 text-sm font-medium mb-1 block">Pencarian</label>
                <div class="relative h-10">
                    <input type="text" id="search" placeholder="Cari Berdasarkan Keperluan"
                        class="w-full h-full pl-10 pr-3 border border-gray-300 bg-white text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================= --}}
    {{-- CARD TABEL --}}
    {{-- ========================= --}}
    <div class="bg-white shadow-lg rounded-2xl p-4 w-full max-w-7xl mx-auto overflow-x-auto font-inter text-[14px]">
        <h2 class="text-gray-700 text-lg font-medium mb-4">Pengajuan Terbaru</h2>
        <hr class="mb-4 border-gray-200">

        <div class="min-w-[900px]" id="table-body">

            {{-- Header --}}
            <div class="grid grid-cols-5 gap-6 font-semibold mb-2 px-1">
                <p>Jenis Surat</p>
                <p class="col-span-1">Keperluan</p>
                <p>Tanggal</p>
                <p>Status</p>
                <p>Aksi</p>
            </div>

            {{-- Data Dinamis --}}
            @foreach ($suratList as $item)
                @php
                    $statusColors = [
                        'Verifikasi' => 'bg-yellow-400',
                        'Proses' => 'bg-orange-500',
                        'Selesai' => 'bg-green-500',
                        'Ditolak' => 'bg-red-500',
                    ];
                    $color = $statusColors[$item->status] ?? 'bg-gray-400';
                @endphp

                <div class="grid grid-cols-5 gap-6 items-center bg-gray-50 p-3 rounded-xl row-item">

                    <p class="jenis">{{ $item->jenis }}</p>

                    <p class="col-span-1 keperluan">{{ $item->keperluan }}</p>

                    <p class="tanggal">{{ $item->tanggal->format('d M Y') }}</p>

                    <div
                        class="rounded px-3 py-1 text-white text-center w-fit text-[12px] status
                        @if ($item->status === 'Verifikasi') bg-yellow-400
                        @elseif($item->status === 'Proses') bg-orange-500
                        @elseif($item->status === 'Selesai') bg-green-500
                        @elseif($item->status === 'Ditolak') bg-red-500
                        @else bg-gray-400 @endif">
                        {{ $item->status }}
                    </div>

                    <div class="flex gap-3 actions">

                        {{-- Tombol Lihat --}}
                        <a href="{{ route('riwayat-pengajuan.detail', $item->id) }}"
                            class="px-3 py-1 rounded font-semibold text-sm hover:bg-gray-200 text-blue-600">
                            Lihat
                        </a>


                        {{-- Download hanya jika selesai --}}
                        @if ($item->status === 'disetujui')
                            <button
                                onclick="downloadPDF('{{ $item->nomor_surat }}', '{{ $item->jenisSurat->nama }}', '{{ $item->keperluan }}', '{{ $item->created_at->format('d M Y') }}')"
                                class="px-3 py-1 rounded font-semibold text-sm hover:bg-gray-200 text-green-600">
                                Download
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    {{-- ========================= --}}
    {{-- PAGINATION --}}
    {{-- ========================= --}}
    <div class="max-w-7xl mx-auto flex justify-between items-center mt-6 px-1 text-[14px]">
        <div id="pagination-info">Menampilkan 1 hingga 5 dari {{ $suratList->count() }} hasil</div>
        <div class="flex gap-1" id="pagination-controls"></div>
    </div>

    {{-- ========================= --}}
    {{-- FILTER, SEARCH, PAGINATION --}}
    {{-- ========================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterStatus = document.getElementById('filter-status');
            const filterJenis = document.getElementById('filter-jenis-surat');
            const searchInput = document.getElementById('search');
            const rows = Array.from(document.querySelectorAll('.row-item'));
            const info = document.getElementById('pagination-info');
            const controls = document.getElementById('pagination-controls');

            let currentPage = 1;
            const rowsPerPage = 5;

            function renderTable() {
                const statusVal = filterStatus.value.toLowerCase();
                const jenisVal = filterJenis.value.toLowerCase();
                const searchVal = searchInput.value.toLowerCase();

                const filtered = rows.filter(row => {
                    const status = row.querySelector('.status').textContent.toLowerCase();
                    const jenis = row.querySelector('.jenis').textContent.toLowerCase();
                    const keperluan = row.querySelector('.keperluan').textContent.toLowerCase();

                    return (
                        (status.includes(statusVal) || statusVal === '') &&
                        (jenis.includes(jenisVal) || jenisVal === '') &&
                        (keperluan.includes(searchVal) || searchVal === '')
                    );
                });

                const totalRows = filtered.length;
                const totalPages = Math.ceil(totalRows / rowsPerPage);
                if (currentPage > totalPages) currentPage = 1;

                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                rows.forEach(r => r.style.display = 'none');
                filtered.slice(start, end).forEach(r => r.style.display = '');

                info.textContent =
                    `Menampilkan ${start + 1} hingga ${end > totalRows ? totalRows : end} dari ${totalRows} hasil`;

                controls.innerHTML = '';

                if (totalPages <= 1) return;

                // Prev Button
                const prevBtn = document.createElement('button');
                prevBtn.className = 'w-8 h-8 border border-gray-300 rounded hover:bg-gray-100';
                prevBtn.textContent = '<';
                prevBtn.disabled = currentPage === 1;
                prevBtn.onclick = () => {
                    currentPage--;
                    renderTable();
                };
                controls.appendChild(prevBtn);

                // Page Numbers
                for (let i = 1; i <= totalPages; i++) {
                    const bn = document.createElement('button');
                    bn.className =
                        `w-8 h-8 border rounded ${i === currentPage ? 'bg-blue-500 text-white border-blue-500' : 'border-gray-300 hover:bg-gray-100'}`;
                    bn.textContent = i;
                    bn.onclick = () => {
                        currentPage = i;
                        renderTable();
                    };
                    controls.appendChild(bn);
                }

                // Next Button
                const nextBtn = document.createElement('button');
                nextBtn.className = 'w-8 h-8 border border-gray-300 rounded hover:bg-gray-100';
                nextBtn.textContent = '>';
                nextBtn.disabled = currentPage === totalPages;
                nextBtn.onclick = () => {
                    currentPage++;
                    renderTable();
                };
                controls.appendChild(nextBtn);
            }

            filterStatus.onchange = () => {
                currentPage = 1;
                renderTable();
            };
            filterJenis.onchange = () => {
                currentPage = 1;
                renderTable();
            };
            searchInput.oninput = () => {
                currentPage = 1;
                renderTable();
            };

            renderTable();
        });
    </script>

    {{-- ========================= --}}
    {{-- DOWNLOAD PDF --}}
    {{-- ========================= --}}
    <script>
        async function downloadPDF(no, jenis, keperluan, tanggal) {
            const {
                jsPDF
            } = window.jspdf;
            const pdf = new jsPDF();

            pdf.setFont("Helvetica", "bold");
            pdf.setFontSize(16);
            pdf.text("Dokumen Surat", 20, 20);

            pdf.setFont("Helvetica", "normal");
            pdf.setFontSize(12);

            pdf.text(`Nomor Surat      : ${no}`, 20, 40);
            pdf.text(`Jenis Surat      : ${jenis}`, 20, 50);
            pdf.text(`Keperluan        : ${keperluan}`, 20, 60);
            pdf.text(`Tanggal Dibuat   : ${tanggal}`, 20, 70);

            pdf.line(20, 75, 190, 75);
            pdf.text("Dokumen ini dihasilkan otomatis dari Riwayat Pengajuan.", 20, 90);

            pdf.save(`SURAT-${no}.pdf`);
        }
    </script>
@endsection
