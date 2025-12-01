{{-- resources/views/components/admin/pemohon/pemohon --}}

{{-- Card Filter & Search --}}
<div class="bg-white p-6 w-full max-w-7xl mx-auto mb-6">
    <div class="flex flex-wrap gap-6 items-start">

        {{-- Filter --}}
        @php
        $filters = [
            ['id'=>'filter-status','label'=>'Filter Status','options'=>[''=>'Semua Status','Baru'=>'Baru','Proses'=>'Proses','Selesai'=>'Selesai']],
            ['id'=>'filter-jenis-surat','label'=>'Filter Jenis Surat','options'=>[''=>'Semua Jenis Surat','Surat Domisili'=>'Surat Domisili','Pengantar SKCK'=>'Pengantar SKCK','Surat Usaha'=>'Surat Usaha']]
        ];
        @endphp

        @foreach($filters as $filter)
        <div>
            <label for="{{ $filter['id'] }}" class="text-gray-700 text-sm font-medium mb-1 block">{{ $filter['label'] }}</label>
            <div class="relative w-[223px]">
                <select id="{{ $filter['id'] }}" class="w-full h-10 px-3 border border-gray-300 bg-white text-gray-600 text-sm rounded-lg">
                    @foreach($filter['options'] as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
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
    
    <h2 class="text-gray-700 text-lg font-medium mb-4">Permohonan Terbaru</h2>
    <hr class="mb-4 border-gray-200">

    @php
    $rows = [
        ['nama'=>'Siti Rahayu','nik'=>'2323283823283','jenis'=>'Surat Domisili','status'=>'Baru'],
        ['nama'=>'Budi Santoso','nik'=>'2932839293923','jenis'=>'Pengantar SKCK','status'=>'Proses'],
        ['nama'=>'Dewi Lestari','nik'=>'30293929392992','jenis'=>'Surat Usaha','status'=>'Selesai'],

    ];

    $statusStyles = [
        'Baru'     => 'bg-yellow-100 text-yellow-800',
        'Proses'   => 'bg-orange-100 text-orange-800',
        'Selesai'  => 'bg-green-100 text-green-800',
    ];
    @endphp

    <div class="min-w-[900px]" id="table-body">

        {{-- Header --}}
        <div class="grid grid-cols-5 gap-6 text-[#111827] text-[14px] font-semibold mb-2 px-1">
            <p>Nama Penduduk</p>
            <p>NIK</p>
            <p>Jenis Surat</p>
            <p>Status</p>
            <p>Aksi</p>
        </div>

        {{-- Rows --}}
        @foreach($rows as $item)
        <div class="row-item grid grid-cols-5 gap-6 items-center bg-gray-50 p-3 rounded-xl">
            
            <p class="nama">{{ $item['nama'] }}</p>
            <p class="nik">{{ $item['nik'] }}</p>
            <p class="jenis">{{ $item['jenis'] }}</p>

            {{-- STATUS BADGE --}}
            <div class="status rounded-lg px-3 py-1 font-semibold text-center w-fit text-[12px]
                {{ $statusStyles[$item['status']] ?? 'bg-gray-100 text-gray-800' }}">
                {{ $item['status'] }}
            </div>

            <div class="flex gap-3 actions">
                <a href="#" class="text-blue-600 font-semibold hover:underline text-center">Lihat & Proses</a>
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

    const rows = Array.from(document.querySelectorAll('.row-item'));
    const info = document.getElementById('pagination-info');
    const controls = document.getElementById('pagination-controls');

    let currentPage = 1;
    const rowsPerPage = 10;

    function renderTable() {

        const statusVal = filterStatus.value.toLowerCase();
        const jenisVal = filterJenis.value.toLowerCase();
        const searchVal = searchInput.value.toLowerCase();

        const filtered = rows.filter(row => {
            const nama       = row.querySelector('.nama').textContent.toLowerCase();
            const nik        = row.querySelector('.nik').textContent.toLowerCase();
            const jenis      = row.querySelector('.jenis').textContent.toLowerCase();
            const status     = row.querySelector('.status').textContent.toLowerCase();

            return (status.includes(statusVal) || statusVal === '') &&
                   (jenis.includes(jenisVal)  || jenisVal  === '') &&
                   (nama.includes(searchVal) || nik.includes(searchVal) || searchVal === '');
        });

        const totalRows = filtered.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;

        if (currentPage > totalPages) currentPage = 1;

        const start = (currentPage - 1) * rowsPerPage;
        const end   = start + rowsPerPage;

        // Reset table
        rows.forEach(r => r.style.display = 'none');
        filtered.slice(start, end).forEach(r => r.style.display = '');

        // Info text
        const startRow = totalRows === 0 ? 0 : start + 1;
        const endRow = end > totalRows ? totalRows : end;

        info.textContent = `Menampilkan ${startRow} hingga ${endRow} dari ${totalRows} hasil`;

        // Build pagination UI
        controls.innerHTML = '';

        if (totalPages > 1) {

            // PREV BUTTON
            const prevBtn = document.createElement('button');
            prevBtn.className = 'flex items-center justify-center w-8 h-8 border border-gray-300 rounded hover:bg-gray-100 disabled:opacity-40';
            prevBtn.innerHTML = `
                <svg class="w-4 h-4" fill="none" stroke="currentColor" 
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        stroke-width="2" d="M15 19l-7-7 7-7">
                    </path>
                </svg>`;
            prevBtn.disabled = currentPage === 1;
            prevBtn.addEventListener('click', () => {
                currentPage--;
                renderTable();
            });
            controls.appendChild(prevBtn);

            // NUMBER BUTTONS
            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.className = `
                    flex items-center justify-center w-8 h-8 border rounded font-semibold 
                    ${i === currentPage 
                        ? 'border-blue-500 bg-blue-500 text-white' 
                        : 'border-gray-300 text-gray-700 hover:bg-gray-100'}
                `;
                btn.textContent = i;
                btn.addEventListener('click', () => {
                    currentPage = i;
                    renderTable();
                });
                controls.appendChild(btn);
            }

            // NEXT BUTTON
            const nextBtn = document.createElement('button');
            nextBtn.className = 'flex items-center justify-center w-8 h-8 border border-gray-300 rounded hover:bg-gray-100 disabled:opacity-40';
            nextBtn.innerHTML = `
                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        stroke-width="2" d="M9 5l7 7-7 7">
                    </path>
                </svg>`;
            nextBtn.disabled = currentPage === totalPages;
            nextBtn.addEventListener('click', () => {
                currentPage++;
                renderTable();
            });
            controls.appendChild(nextBtn);
        }
    }

    // EVENTS
    filterStatus.addEventListener('change', () => { currentPage = 1; renderTable(); });
    filterJenis.addEventListener('change', () => { currentPage = 1; renderTable(); });
    searchInput.addEventListener('input', () => { currentPage = 1; renderTable(); });

    // INIT
    renderTable();
});
</script>
