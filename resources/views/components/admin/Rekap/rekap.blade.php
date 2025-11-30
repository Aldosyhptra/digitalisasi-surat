{{-- Filter + Search + Download --}}
<div class="p-6 bg-white rounded-xl shadow-md">
    <div class="flex flex-wrap items-end gap-6 mb-6">

        {{-- Filter Laporan (Bulan) --}}
        <div>
            <label for="filter-bulan" class="text-gray-700 text-sm font-medium mb-1 block">Filter Laporan</label>
            <select id="filter-bulan" class="appearance-none w-48 h-10 px-3 border border-gray-300 bg-white text-gray-700 text-sm rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="">Bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
        </div>

        {{-- Search --}}
        <div class="flex-1 min-w-[200px]">
            <label for="search" class="text-gray-700 text-sm font-medium mb-1 block">Pencarian</label>
            <input type="text" id="search" placeholder="Cari berdasarkan jenis surat" class="w-full h-10 pl-3 pr-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm">
        </div>

        {{-- Download Buttons --}}
        <div class="flex gap-3 ml-auto">
            <button id="download-pdf" class="h-10 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 rounded-lg text-sm flex items-center justify-center gap-2">
                <i class="fa-solid fa-file-pdf"></i> Download PDF
            </button>
            <button id="download-excel" class="h-10 bg-green-500 hover:bg-green-600 text-white font-semibold px-4 rounded-lg text-sm flex items-center justify-center gap-2">
                <i class="fa-solid fa-file-excel"></i> Download Excel
            </button>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="bg-white shadow-lg rounded-2xl p-5 w-full mt-6">
    <h2 class="text-xl font-semibold text-gray-700 mb-3">Rekap Per Jenis Surat</h2>
    <hr class="mb-4 border-gray-300">
    <div class="w-full overflow-x-auto">
        <div class="min-w-[700px] lg:min-w-[800px]">

            {{-- Header --}}
            <div class="grid grid-cols-6 gap-3 text-gray-600 text-[15px] font-semibold mb-3 px-1 text-center">
                <p>Jenis Surat</p>
                <p>Total</p>
                <p>Selesai</p>
                <p>Proses</p>
                <p>Ditolak</p>
                <p>Persentase Selesai</p>
            </div>

            {{-- Table Body (Data Dummy) --}}
            <div id="table-body" class="space-y-3 text-[14px] text-gray-700 text-center">
                <div class="row-item grid grid-cols-6 gap-3 items-center bg-gray-50 p-3 rounded-xl">
                    <p class="jenis">Surat Domisili</p>
                    <p class="total">25</p>
                    <p class="selesai">15</p>
                    <p class="proses">7</p>
                    <p class="ditolak">3</p>
                    <p class="font-semibold text-[#04C220] persen">60%</p>
                    <p class="hidden bulan-val">1</p>
                </div>
                <div class="row-item grid grid-cols-6 gap-3 items-center bg-gray-50 p-3 rounded-xl">
                    <p class="jenis">Pengantar SKCK</p>
                    <p class="total">18</p>
                    <p class="selesai">12</p>
                    <p class="proses">4</p>
                    <p class="ditolak">2</p>
                    <p class="font-semibold text-[#04C220] persen">67%</p>
                    <p class="hidden bulan-val">2</p>
                </div>
                <div class="row-item grid grid-cols-6 gap-3 items-center bg-gray-50 p-3 rounded-xl">
                    <p class="jenis">Surat Usaha</p>
                    <p class="total">10</p>
                    <p class="selesai">6</p>
                    <p class="proses">3</p>
                    <p class="ditolak">1</p>
                    <p class="font-semibold text-[#04C220] persen">60%</p>
                    <p class="hidden bulan-val">3</p>
                </div>
                <div class="row-item grid grid-cols-6 gap-3 items-center bg-gray-50 p-3 rounded-xl">
                    <p class="jenis">Surat Kematian</p>
                    <p class="total">8</p>
                    <p class="selesai">5</p>
                    <p class="proses">2</p>
                    <p class="ditolak">1</p>
                    <p class="font-semibold text-[#04C220] persen">62%</p>
                    <p class="hidden bulan-val">1</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Pagination (UI sama seperti contoh awal) --}}
<div class="max-w-7xl mx-auto flex justify-between items-center mt-6 px-1 text-[14px] text-[#111827] font-inter">
    <div id="pagination-info">Menampilkan 1 hingga 5 dari 4 hasil</div>
    <div class="flex gap-1" id="pagination-controls"></div>
</div>

{{-- JS Filter + Search + Pagination + Download (UI Pagination seperti contoh awal) --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBulan = document.getElementById('filter-bulan');
    const searchInput = document.getElementById('search');
    const rows = Array.from(document.querySelectorAll('.row-item'));
    const info = document.getElementById('pagination-info');
    const controls = document.getElementById('pagination-controls');

    const downloadPdfBtn = document.getElementById('download-pdf');
    const downloadExcelBtn = document.getElementById('download-excel');

    let currentPage = 1;
    const rowsPerPage = 10;

    function renderTable() {
        const bulanVal = filterBulan.value;
        const searchVal = searchInput.value.toLowerCase();

        const filtered = rows.filter(row => {
            const jenisText = row.querySelector('.jenis').textContent.toLowerCase();
            const persenText = row.querySelector('.persen').textContent.toLowerCase();
            const bulanRow = row.querySelector('.bulan-val').textContent;

            return (bulanVal === '' || bulanVal === bulanRow) &&
                   (searchVal === '' || jenisText.includes(searchVal) || persenText.includes(searchVal));
        });

        const totalRows = filtered.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        if(currentPage > totalPages) currentPage = 1;

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        // Reset table
        rows.forEach(r => r.style.display = 'none');
        filtered.slice(start, end).forEach(r => r.style.display = '');

        const startRow = totalRows === 0 ? 0 : start + 1;
        const endRow = end > totalRows ? totalRows : end;
        info.textContent = `Menampilkan ${startRow} hingga ${endRow} dari ${totalRows} hasil`;

        // Build pagination UI
        controls.innerHTML = '';
        if(totalPages > 1) {
            // PREV
            const prevBtn = document.createElement('button');
            prevBtn.className = 'flex items-center justify-center w-8 h-8 border border-gray-300 rounded hover:bg-gray-100 disabled:opacity-40';
            prevBtn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>`;
            prevBtn.disabled = currentPage === 1;
            prevBtn.addEventListener('click', () => { currentPage--; renderTable(); });
            controls.appendChild(prevBtn);

            // Numbers
            for(let i=1;i<=totalPages;i++){
                const btn = document.createElement('button');
                btn.className = `flex items-center justify-center w-8 h-8 border rounded font-semibold ${i===currentPage?'border-blue-500 bg-blue-500 text-white':'border-gray-300 text-gray-700 hover:bg-gray-100'}`;
                btn.textContent = i;
                btn.addEventListener('click', () => { currentPage=i; renderTable(); });
                controls.appendChild(btn);
            }

            // NEXT
            const nextBtn = document.createElement('button');
            nextBtn.className = 'flex items-center justify-center w-8 h-8 border border-gray-300 rounded hover:bg-gray-100 disabled:opacity-40';
            nextBtn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>`;
            nextBtn.disabled = currentPage === totalPages;
            nextBtn.addEventListener('click', () => { currentPage++; renderTable(); });
            controls.appendChild(nextBtn);
        }
    }

    // Download Excel
    downloadExcelBtn.addEventListener('click', function() {
        const wb = XLSX.utils.book_new();
        const wsData = [["Jenis Surat","Total","Selesai","Proses","Ditolak","Persentase Selesai"]];
        rows.forEach(row => {
            if(row.style.display !== 'none'){
                wsData.push([
                    row.querySelector('.jenis').textContent,
                    row.querySelector('.total').textContent,
                    row.querySelector('.selesai').textContent,
                    row.querySelector('.proses').textContent,
                    row.querySelector('.ditolak').textContent,
                    row.querySelector('.persen').textContent
                ]);
            }
        });
        const ws = XLSX.utils.aoa_to_sheet(wsData);
        XLSX.utils.book_append_sheet(wb, ws, "Rekap Surat");
        XLSX.writeFile(wb, "Rekap_Surat.xlsx");
    });

    // Download PDF
    downloadPdfBtn.addEventListener('click', function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        let y = 10;
        doc.setFontSize(12);
        doc.text("Rekap Per Jenis Surat", 10, y);
        y += 10;
        const headers = ["Jenis Surat","Total","Selesai","Proses","Ditolak","Persentase Selesai"];
        headers.forEach((h, i) => doc.text(h, 10 + i*30, y));
        y += 7;
        rows.forEach(row => {
            if(row.style.display !== 'none'){
                const data = [
                    row.querySelector('.jenis').textContent,
                    row.querySelector('.total').textContent,
                    row.querySelector('.selesai').textContent,
                    row.querySelector('.proses').textContent,
                    row.querySelector('.ditolak').textContent,
                    row.querySelector('.persen').textContent
                ];
                data.forEach((d,i) => doc.text(d, 10 + i*30, y));
                y += 7;
            }
        });
        doc.save("Rekap_Surat.pdf");
    });

    filterBulan.addEventListener('change', () => { currentPage = 1; renderTable(); });
    searchInput.addEventListener('input', () => { currentPage = 1; renderTable(); });

    renderTable();
});
</script>
