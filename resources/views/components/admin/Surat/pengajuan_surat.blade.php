<div class="max-w-4xl mx-auto">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Upload Template Surat</h1>
        <p class="text-gray-600 mt-2">Upload template DOCX dan definisikan apa saja yang diperlukan</p>
    </div>

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg p-6" x-data="templateUploader()">
        <form action="{{ route('admin.surat.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Pilih Jenis Surat --}}
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-file-alt text-blue-600 mr-2"></i>Pilih Jenis Surat
                    </label>
                    <button type="button" @click="showModal = true"
                        class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Jenis Baru
                    </button>
                </div>

                <select name="jenis_surat_id" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Jenis Surat --</option>
                    @foreach ($jenisSuratList as $jenis)
                        <option value="{{ $jenis->id }}">
                            {{ $jenis->nama_surat }}
                            @if ($jenis->jenis)
                                ({{ ucfirst($jenis->jenis) }})
                            @endif
                        </option>
                    @endforeach
                </select>

                @error('jenis_surat_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Modal Tambah Jenis Surat --}}
            <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

                {{-- Backdrop --}}
                <div class="fixed inset-0 bg-black/50 transition-opacity" @click="showModal = false"></div>

                {{-- Modal Content --}}
                <div class="flex min-h-screen items-center justify-center p-4">
                    <div class="relative bg-white rounded-xl shadow-2xl max-w-md w-full p-6"
                        @click.away="showModal = false">

                        {{-- Header --}}
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-800">
                                <i class="fas fa-plus-circle text-blue-600 mr-2"></i>
                                Tambah Jenis Surat Baru
                            </h3>
                            <button type="button" @click="showModal = false"
                                class="text-gray-400 hover:text-gray-600 transition">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        {{-- Form --}}
                        <form id="form-tambah-jenis" @submit.prevent="submitJenisSurat">

                            {{-- Nama Surat --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Surat <span class="text-red-500">*</span>
                                </label>
                                <input type="text" x-model="formData.nama_surat"
                                    placeholder="Contoh: Surat Keterangan Kelahiran"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            {{-- Kategori/Jenis --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select x-model="formData.jenis"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="sktm">SKTM</option>
                                    <option value="domisili">Domisili</option>
                                    <option value="usaha">Usaha</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi <span class="text-red-500">*</span>
                                </label>
                                <textarea x-model="formData.deskripsi" rows="3" placeholder="Contoh: Surat keterangan untuk..."
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                    required></textarea>
                            </div>

                            {{-- Loading & Error States --}}
                            <div x-show="loading" class="mb-4 text-center text-sm text-gray-600">
                                <i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...
                            </div>

                            <div x-show="error"
                                class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span x-text="error"></span>
                            </div>

                            {{-- Buttons --}}
                            <div class="flex gap-3">
                                <button type="submit" :disabled="loading"
                                    class="flex-1 bg-blue-600 text-white py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-save mr-2"></i>Simpan
                                </button>
                                <button type="button" @click="showModal = false" :disabled="loading"
                                    class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition disabled:opacity-50">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            {{-- Upload File --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-file-word text-blue-600 mr-2"></i>File Template (.docx)
                </label>
                <input type="file" name="template_file" accept=".docx" required
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 p-2.5">
                <p class="text-xs text-gray-500 mt-2">
                    Gunakan placeholder: <code class="bg-gray-100 px-2 py-1 rounded">${'nama'}</code>
                </p>
                @error('template_file')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Dynamic Fields --}}
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-list text-blue-600 mr-2"></i>Field yang Diperlukan
                    </label>
                    <button type="button" @click="addField"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Tambah Field
                    </button>
                </div>

                <div class="space-y-3">
                    <template x-for="(field, index) in fields" :key="index">
                        <div class="flex gap-3 items-start bg-gray-50 p-4 rounded-lg border">
                            <div class="flex-1">
                                <input type="text" x-model="field.name" :name="'fields[' + index + '][name]'"
                                    placeholder="nama" class="w-full px-3 py-2 border rounded-lg" required>
                            </div>
                            <div class="flex-1">
                                <input type="text" x-model="field.label" :name="'fields[' + index + '][label]'"
                                    placeholder="Nama Lengkap" class="w-full px-3 py-2 border rounded-lg" required>
                            </div>
                            <div class="w-32">
                                <select x-model="field.type" :name="'fields[' + index + '][type]'"
                                    class="w-full px-3 py-2 border rounded-lg">
                                    <option value="text">Text</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="date">Tanggal</option>
                                    <option value="number">Angka</option>
                                </select>
                            </div>
                            <div class="flex items-center pt-2">
                                <input type="checkbox" x-model="field.required"
                                    :name="'fields[' + index + '][required]'" class="w-4 h-4">
                                <label class="ml-1 text-sm">Wajib</label>
                            </div>
                            <button type="button" @click="removeField(index)"
                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </template>
                </div>

                <div x-show="fields.length === 0" class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-3"></i>
                    <p>Klik "Tambah Field" untuk menambahkan field</p>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700">
                    <i class="fas fa-upload mr-2"></i>Upload Template
                </button>
                <a href="{{ route('admin.surat') }}"
                    class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    function templateUploader() {
        return {
            fields: [],
            showModal: false,
            loading: false,
            error: '',
            formData: {
                nama_surat: '',
                jenis: '',
                deskripsi: ''
            },

            addField() {
                this.fields.push({
                    name: '',
                    label: '',
                    type: 'text',
                    required: true
                });
            },

            removeField(index) {
                this.fields.splice(index, 1);
            },

            async submitJenisSurat() {
                this.loading = true;
                this.error = '';

                try {
                    const response = await fetch('{{ route('admin.jenis_surat.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.formData)
                    });

                    const data = await response.json();

                    if (response.ok) {
                        const select = document.querySelector('select[name="jenis_surat_id"]');
                        const option = new Option(
                            `${data.jenis_surat.nama_surat} (${data.jenis_surat.jenis})`,
                            data.jenis_surat.id,
                            false,
                            true
                        );
                        select.add(option);

                        this.formData = {
                            nama_surat: '',
                            jenis: '',
                            deskripsi: ''
                        };
                        this.showModal = false;

                        alert('Jenis surat berhasil ditambahkan!');
                    } else {
                        this.error = data.message || 'Gagal menyimpan data';
                    }
                } catch (err) {
                    this.error = 'Terjadi kesalahan saat menyimpan';
                    console.error(err);
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
