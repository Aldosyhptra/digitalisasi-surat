{{-- resources/views/components/Pengguna/RiwayatPengajuan/riwayat.blade.php --}}

{{-- Card Filter & Search --}}
<div class="bg-white p-6 w-full max-w-7xl mx-auto mb-6">
    <div class="flex flex-wrap gap-6 items-start">

        {{-- Filter --}}
        @php
        $filters = [
            ['id'=>'filter-status','label'=>'Filter Status','options'=>[''=>'Semua Status','Verifikasi'=>'Verifikasi','Proses'=>'Proses','Selesai'=>'Selesai','Ditolak'=>'Ditolak']],
            ['id'=>'filter-jenis-surat','label'=>'Filter Jenis Surat','options'=>[''=>'Semua Jenis Surat','Keterangan Domisili'=>'Keterangan Domisili','Pengantar SKCK'=>'Pengantar SKCK','Keterangan Usaha'=>'Keterangan Usaha']]
        ];
        @endphp

        @foreach($filters as $filter)
        <div>
            <label for="{{ $filter['id'] }}" class="text-gray-700 text-sm font-medium mb-1 block">{{ $filter['label'] }}</label>
            <div class="relative w-[223px]">
                <select id="{{ $filter['id'] }}" class="w-full h-10 px-3 border border-gray-300 bg-white text-gray-600 text-sm rounded-lg appearance-none focus:ring-blue-500 focus:border-blue-500 cursor-pointer">
                    @foreach($filter['options'] as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Card Tabel --}}
<div class="bg-white shadow-lg rounded-2xl p-4 w-full max-w-7xl mx-auto overflow-x-auto font-inter text-[14px] text-[#111827]">
    <h2 class="text-gray-700 text-lg font-medium mb-4">Pengajuan Terbaru</h2>
    <hr class="mb-4 border-gray-200">

    @php
    $rows = [
        ['no'=>'AA34','jenis'=>'Keterangan Domisili','keperluan'=>'Surat Keterangan Domisili','tanggal'=>'12 Nov 2025','status'=>'Verifikasi','color'=>'bg-yellow-400','actions'=>['Lihat']],
        ['no'=>'AB233','jenis'=>'Pengantar SKCK','keperluan'=>'Surat Pengantar SKCK','tanggal'=>'14 Nov 2025','status'=>'Proses','color'=>'bg-orange-500','actions'=>['Lihat']],
        ['no'=>'AC54','jenis'=>'Keterangan Usaha','keperluan'=>'Surat Keterangan Usaha','tanggal'=>'18 Nov 2025','status'=>'Selesai','color'=>'bg-green-500','actions'=>['Lihat','Download']],
        ['no'=>'AD12','jenis'=>'Pengantar SKCK','keperluan'=>'Surat Pengantar SKCK','tanggal'=>'14 Nov 2025','status'=>'Ditolak','color'=>'bg-red-500','actions'=>['Lihat']],
        ['no'=>'AE44','jenis'=>'Keterangan Domisili','keperluan'=>'Surat Keterangan Domisili','tanggal'=>'16 Nov 2025','status'=>'Verifikasi','color'=>'bg-yellow-400','actions'=>['Lihat']],
    ];
    @endphp

    <div class="min-w-[900px]" id="table-body">
        {{-- Header --}}
        <div class="grid grid-cols-7 gap-6 text-[#111827] text-[14px] font-inter font-semibold mb-2 px-1">
            <p>Jenis Surat</p>
            <p>No. Surat</p>
            <p class="col-span-2">Keperluan</p>
            <p>Tanggal</p>
            <p>Status</p>
            <p>Aksi</p>
        </div>

        {{-- Data Rows --}}
        @foreach($rows as $item)
        <div class="grid grid-cols-7 gap-6 items-center bg-gray-50 p-3 rounded-xl hover:bg-gray-50 transition row-item">
            <p class="jenis">{{ $item['jenis'] }}</p>
            <p class="no">{{ $item['no'] }}</p>
            <p class="col-span-2 keperluan">{{ $item['keperluan'] }}</p>
            <p class="tanggal">{{ $item['tanggal'] }}</p>
            <div class="rounded px-3 py-1 {{ $item['color'] }} text-white font-semibold text-center w-fit text-[12px] status">{{ $item['status'] }}</div>
            <div class="flex gap-3 actions">
                @foreach($item['actions'] as $action)
                    <a href="#" class="px-3 py-1 rounded font-semibold text-[14px] transition hover:bg-gray-200 {{ $action=='Download' ? 'text-green-600' : 'text-blue-600' }}">{{ $action }}</a>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Pagination --}}
<div class="max-w-7xl mx-auto flex justify-between items-center mt-6 px-1 text-[14px] text-[#111827] font-inter">
    <div id="pagination-info">Menampilkan 1 hingga 5 dari {{ count($rows) }} hasil</div>
    <div class="flex gap-1" id="pagination-controls"></div>
</div>

{{-- Filter, Search & Pagination JS --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterStatus = document.getElementById('filter-status');
    const filterJenis = document.getElementById('filter-jenis-surat');
    const searchInput = document.getElementById('search');
    const tableBody = document.getElementById('table-body');
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
            return (status.includes(statusVal) || statusVal === '') &&
                   (jenis.includes(jenisVal) || jenisVal === '') &&
                   (keperluan.includes(searchVal) || searchVal === '');
        });

        const totalRows = filtered.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);
        if(currentPage > totalPages) currentPage = 1;
        const start = (currentPage-1)*rowsPerPage;
        const end = start + rowsPerPage;

        rows.forEach(r => r.style.display = 'none');
        filtered.slice(start, end).forEach(r => r.style.display = '');

        const startRow = totalRows === 0 ? 0 : start + 1;
        const endRow = end > totalRows ? totalRows : end;
        info.textContent = `Menampilkan ${startRow} hingga ${endRow} dari ${totalRows} hasil`;

        // Render pagination buttons
        controls.innerHTML = '';
        if(totalPages <= 1) return;

        const prevBtn = document.createElement('button');
        prevBtn.className = 'flex items-center justify-center w-8 h-8 border border-gray-300 rounded hover:bg-gray-100';
        prevBtn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>`;
        prevBtn.disabled = currentPage === 1;
        prevBtn.addEventListener('click', () => { currentPage--; renderTable(); });
        controls.appendChild(prevBtn);

        for(let i=1; i<=totalPages; i++){
            const btn = document.createElement('button');
            btn.className = `flex items-center justify-center w-8 h-8 border ${i===currentPage?'border-blue-500 bg-blue-500 text-white':'border-gray-300 text-gray-700 hover:bg-gray-100'} rounded font-semibold`;
            btn.textContent = i;
            btn.addEventListener('click', ()=> { currentPage=i; renderTable(); });
            controls.appendChild(btn);
        }

        const nextBtn = document.createElement('button');
        nextBtn.className = 'flex items-center justify-center w-8 h-8 border border-gray-300 rounded hover:bg-gray-100';
        nextBtn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>`;
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.addEventListener('click', () => { currentPage++; renderTable(); });
        controls.appendChild(nextBtn);
    }

    filterStatus.addEventListener('change', () => { currentPage=1; renderTable(); });
    filterJenis.addEventListener('change', () => { currentPage=1; renderTable(); });
    searchInput.addEventListener('input', () => { currentPage=1; renderTable(); });

    renderTable();
});
</script>
