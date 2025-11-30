{{-- Card Filter --}}
<div class="bg-white p-6 w-full max-w-7xl mx-auto rounded-xl shadow-md border border-gray-100 mb-6">

    {{-- Header & Button --}}
   <div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Manajemen Surat</h2>
    <button id="btn-tambah" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
        <i class="fa fa-plus"></i>
        Tambah Surat
    </button>
</div>


    {{-- Filter + Search --}}
    <div class="flex flex-wrap gap-6 items-start">
        <div>
            <label for="filter-status" class="text-gray-700 text-sm font-medium mb-1 block">Filter Status</label>
            <div class="relative w-[223px]">
                <select id="filter-status" class="w-full h-10 px-3 border border-gray-300 bg-white text-gray-600 text-sm rounded-lg">
                    <option value="">Semua Status</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>
        </div>

        <div>
            <label for="filter-jenis-surat" class="text-gray-700 text-sm font-medium mb-1 block">Filter Jenis Surat</label>
            <div class="relative w-[223px]">
                <select id="filter-jenis-surat" class="w-full h-10 px-3 border border-gray-300 bg-white text-gray-600 text-sm rounded-lg">
                    <option value="">Semua Jenis Surat</option>
                    <option value="sktm">SKTM</option>
                    <option value="domisili">Domisili</option>
                    <option value="usaha">Usaha</option>
                    <option value="lain">Lainnya</option>
                </select>
            </div>
        </div>

        <div class="flex-1 min-w-[250px]">
            <label for="search" class="text-gray-700 text-sm font-medium mb-1 block">Pencarian</label>
            <div class="relative h-10">
                <input type="text" id="search" placeholder="Cari Berdasarkan Nama Surat"
                       class="w-full h-full pl-10 pr-3 border border-gray-300 bg-white text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fa fa-search text-gray-500"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Cards Grid --}}
<div id="cards-grid" class="w-full max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    {{-- Cards akan di-render oleh JS --}}
</div>

<script>
    // Data cards
    const cards = [
        {title: 'Surat Keterangan Tidak Mampu', desc: 'Surat keterangan untuk menyatakan ketidakmampuan ekonomi', fields: ['Nama', 'Nik', 'No.KK', '+3 Lainnya'], status: 'Aktif', type: 'sktm'},
        {title: 'Surat Domisili', desc: 'Surat untuk keperluan domisili penduduk', fields: ['Nama', 'Nik', 'Alamat'], status: 'Aktif', type: 'domisili'},
        {title: 'Surat Usaha', desc: 'Surat untuk keperluan usaha penduduk', fields: ['Nama', 'Nik', 'Jenis Usaha'], status: 'Tidak Aktif', type: 'usaha'},
        {title: 'SKTM', desc: 'Surat keterangan tidak mampu', fields: ['Nama', 'Nik', 'No.KK'], status: 'Aktif', type: 'sktm'},
    
    ];

    const icons = {
        sktm: {icon: 'fa-hand-holding-usd', bg: 'bg-yellow-100', color: 'text-yellow-600'},
        domisili: {icon: 'fa-home', bg: 'bg-green-100', color: 'text-green-600'},
        usaha: {icon: 'fa-briefcase', bg: 'bg-purple-100', color: 'text-purple-600'},
        lain: {icon: 'fa-file-alt', bg: 'bg-blue-100', color: 'text-blue-600'},
    };

    const cardsGrid = document.getElementById('cards-grid');

    function renderCards(data) {
        cardsGrid.innerHTML = '';
        data.forEach(card => {
            const iconData = icons[card.type] || icons['lain'];
            const cardEl = document.createElement('div');
            cardEl.className = 'bg-white p-4 border border-gray-200 rounded-lg shadow-sm flex flex-col justify-between h-full relative';

            cardEl.innerHTML = `
                <!-- Edit/Delete kanan atas -->
                <div class="absolute top-2 right-2 flex space-x-3">
                    <button class="text-gray-400 hover:text-blue-500 p-2 text-lg" onclick="alert('Edit: ${card.title}')">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button class="text-gray-400 hover:text-red-500 p-2 text-lg" onclick="alert('Delete: ${card.title}')">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>

                <!-- Icon kiri atas -->
                <div class="flex justify-start mb-3">
                    <div class="${iconData.bg} p-3 rounded-[8px] inline-flex items-center justify-center">
                        <i class="fa ${iconData.icon} ${iconData.color} text-lg"></i>
                    </div>
                </div>

                <!-- Judul + Deskripsi -->
                <div class="mb-4">
                    <h3 class="text-base font-semibold text-gray-800">${card.title}</h3>
                    <p class="text-xs text-gray-500 mt-1">${card.desc}</p>
                </div>

                <!-- Fields -->
                <div class="mb-4">
                    <span class="font-medium text-gray-600 text-xs">Field yang digunakan:</span>
                    <div class="mt-1 flex flex-wrap">
                        ${card.fields.map(f => `<span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-0.5 rounded-full mr-1 mb-1">${f}</span>`).join('')}
                    </div>
                </div>

                <!-- Footer Status -->
                <div class="mt-auto">
                    <button onclick="toggleStatus(this, '${card.title}')" class="w-full ${card.status === 'Aktif' ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-400 hover:bg-gray-500'} text-white text-sm font-semibold py-2 rounded-lg transition duration-150 ease-in-out">
                        ${card.status}
                    </button>
                </div>
            `;
            cardsGrid.appendChild(cardEl);
        });
    }

    function toggleStatus(btn, title) {
        const card = cards.find(c => c.title === title);
        if (!card) return;
        card.status = card.status === 'Aktif' ? 'Tidak Aktif' : 'Aktif';
        renderCards(filteredCards());
    }

    function filteredCards() {
        const status = document.getElementById('filter-status').value;
        const type = document.getElementById('filter-jenis-surat').value;
        const search = document.getElementById('search').value.toLowerCase();

        return cards.filter(c => {
            return (!status || c.status === status) &&
                   (!type || c.type === type) &&
                   (!search || c.title.toLowerCase().includes(search));
        });
    }

    // Event listeners
    document.getElementById('filter-status').addEventListener('change', () => renderCards(filteredCards()));
    document.getElementById('filter-jenis-surat').addEventListener('change', () => renderCards(filteredCards()));
    document.getElementById('search').addEventListener('input', () => renderCards(filteredCards()));
    document.getElementById('btn-tambah').addEventListener('click', () => alert('Tambah Surat'));

    // Initial render
    renderCards(cards);
</script>
