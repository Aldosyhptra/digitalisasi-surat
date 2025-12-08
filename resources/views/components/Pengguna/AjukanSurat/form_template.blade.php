@extends('layouts.pengajuan_surat')

@section('content')

    <div class="w-full mx-auto px-6 py-10">

        {{-- Back --}}
        <a href="{{ route('pengajuan.surat') }}"
            class="inline-flex items-center text-gray-600 hover:text-blue-800 mb-6 text-base">
            <span class="text-xl mr-2">←</span> Kembali
        </a>

        {{-- Alert Errors --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-start gap-2">
                    <i class="fas fa-exclamation-circle mt-0.5 flex-shrink-0"></i>
                    <div>
                        <p class="font-semibold mb-1">Terdapat kesalahan pada form:</p>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- FORM WRAPPER --}}
        <form action="{{ route('ajukan-surat.submit') }}" method="POST"
            class="bg-white shadow-xl rounded-2xl p-12 max-w-7xl mx-auto space-y-12 border border-gray-200"
            id="pengajuanForm">
            @csrf

            <input type="hidden" name="jenis_surat_id" value="{{ $jenisSurat->id }}">

            {{-- Header --}}
            <div class="relative">
                <span class="absolute top-0 right-0 bg-blue-500 text-white px-4 py-1.5 rounded-xl text-sm font-semibold">
                    Template Aktif
                </span>

                <h2 class="text-3xl font-bold text-gray-900">
                    Form Pengajuan: {{ $jenisSurat->nama_surat }}
                </h2>

                <p class="text-gray-600 mt-2">{{ $jenisSurat->deskripsi }}</p>

                <hr class="mt-6 border-gray-300">
            </div>

            {{-- Dynamic Fields dari Database --}}
            @if ($jenisSurat->fields && count($jenisSurat->fields) > 0)
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-5">Data Pengajuan</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($jenisSurat->fields as $field)
                            <div class="{{ in_array($field['type'], ['textarea']) ? 'md:col-span-2' : '' }}">
                                <label for="field_{{ $field['name'] }}"
                                    class="text-sm font-medium text-gray-700 mb-2 block">
                                    {{ $field['label'] }}
                                    @if ($field['required'])
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>

                                @switch($field['type'])
                                    @case('text')
                                    @case('email')

                                    @case('number')
                                        @php
                                            // Auto-fill dari data user yang login
                                            $autoFillValue = '';
                                            $fieldNameLower = strtolower($field['name']);

                                            if (auth()->check()) {
                                                $user = auth()->user();

                                                // Mapping field name ke user attribute
                                                $userFieldMap = [
                                                    'nik' => $user->nik ?? '',
                                                    'nama' => $user->nama ?? '',
                                                    'nama_lengkap' => $user->nama ?? '',
                                                    'email' => $user->email ?? '',
                                                    'alamat' => $user->alamat ?? '',
                                                    'no_wa' => $user->no_wa ?? '',
                                                    'no_telepon' => $user->no_wa ?? '',
                                                    'telepon' => $user->no_wa ?? '',
                                                    'jenis_kelamin' => $user->jenis_kelamin ?? '',
                                                    'tanggal_lahir' => $user->tanggal_lahir ?? '',
                                                ];

                                                $autoFillValue = $userFieldMap[$fieldNameLower] ?? '';
                                            }

                                            $value = old('data_surat.' . $field['name'], $autoFillValue);
                                        @endphp

                                        <input type="{{ $field['type'] }}" id="field_{{ $field['name'] }}"
                                            name="data_surat[{{ $field['name'] }}]" value="{{ $value }}"
                                            placeholder="{{ $field['placeholder'] ?? '' }}"
                                            class="w-full h-12 px-4 border border-gray-300 rounded-xl text-base 
                                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none
                                                  @error('data_surat.' . $field['name']) border-red-500 @enderror"
                                            {{ $field['required'] ? 'required' : '' }}>
                                    @break

                                    @case('date')
                                        @php
                                            // Auto-fill tanggal lahir dari user
                                            $dateValue = '';
                                            if (auth()->check() && strtolower($field['name']) === 'tanggal_lahir') {
                                                $dateValue = auth()->user()->tanggal_lahir ?? '';
                                            }
                                            $value = old('data_surat.' . $field['name'], $dateValue);
                                        @endphp

                                        <input type="date" id="field_{{ $field['name'] }}"
                                            name="data_surat[{{ $field['name'] }}]" value="{{ $value }}"
                                            class="w-full h-12 px-4 border border-gray-300 rounded-xl text-base 
                                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none
                                                  @error('data_surat.' . $field['name']) border-red-500 @enderror"
                                            {{ $field['required'] ? 'required' : '' }}>
                                    @break

                                    @case('textarea')
                                        @php
                                            // Auto-fill alamat dari user untuk textarea
                                            $textareaValue = '';
                                            if (auth()->check() && strtolower($field['name']) === 'alamat') {
                                                $textareaValue = auth()->user()->alamat ?? '';
                                            }
                                            $value = old('data_surat.' . $field['name'], $textareaValue);
                                        @endphp

                                        <textarea id="field_{{ $field['name'] }}" name="data_surat[{{ $field['name'] }}]" rows="{{ $field['rows'] ?? 4 }}"
                                            placeholder="{{ $field['placeholder'] ?? '' }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl text-base 
                                                     focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none
                                                     @error('data_surat.' . $field['name']) border-red-500 @enderror"
                                            {{ $field['required'] ? 'required' : '' }}>{{ $value }}</textarea>
                                    @break

                                    @case('select')
                                        @php
                                            // Auto-fill jenis kelamin dari user untuk select
                                            $selectValue = '';
                                            if (auth()->check() && strtolower($field['name']) === 'jenis_kelamin') {
                                                $selectValue = auth()->user()->jenis_kelamin ?? '';
                                            }
                                            $value = old('data_surat.' . $field['name'], $selectValue);
                                        @endphp

                                        <select id="field_{{ $field['name'] }}" name="data_surat[{{ $field['name'] }}]"
                                            class="w-full h-12 px-4 border border-gray-300 rounded-xl text-base 
                                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none
                                                   @error('data_surat.' . $field['name']) border-red-500 @enderror"
                                            {{ $field['required'] ? 'required' : '' }}>
                                            <option value="">Pilih {{ $field['label'] }}</option>
                                            @foreach ($field['options'] as $option)
                                                <option value="{{ $option }}" {{ $value == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @break

                                    @case('radio')
                                        <div class="space-y-2">
                                            @foreach ($field['options'] as $option)
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="radio" name="data_surat[{{ $field['name'] }}]"
                                                        value="{{ $option }}"
                                                        class="w-4 h-4 text-blue-600 focus:ring-blue-500"
                                                        {{ old('data_surat.' . $field['name']) == $option ? 'checked' : '' }}
                                                        {{ $field['required'] ? 'required' : '' }}>
                                                    <span class="text-sm text-gray-700">{{ $option }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @break
                                @endswitch

                                @error('data_surat.' . $field['name'])
                                    <p class="text-red-500 text-xs mt-1">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror

                                @if (isset($field['hint']))
                                    <p class="text-gray-500 text-xs mt-1">
                                        <i class="fas fa-info-circle mr-1"></i>{{ $field['hint'] }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Info Warning --}}
            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-4">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-lg mt-0.5 flex-shrink-0"></i>
                    <div>
                        <p class="text-sm text-yellow-800 font-medium mb-2">Perhatian:</p>
                        <ul class="text-xs text-yellow-700 space-y-1">
                            <li>• Pastikan semua data yang diisi sudah benar dan sesuai</li>
                            <li>• Surat akan diproses maksimal 3x24 jam kerja</li>
                            <li>• Anda akan mendapat notifikasi setelah surat diproses</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="flex justify-between items-center pt-6">
                <button type="reset"
                    class="flex items-center gap-3 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 text-base hover:bg-gray-100 transition">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>Reset Form</span>
                </button>

                <button type="submit"
                    class="flex items-center gap-3 px-8 py-3 rounded-xl bg-blue-600 text-white text-base hover:bg-blue-700 transition">
                    <i class="fa-solid fa-paper-plane text-lg"></i>
                    <span>Kirim Pengajuan</span>
                </button>
            </div>

        </form>
    </div>

    {{-- Validation Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('pengajuanForm');

            // Validasi form sebelum submit
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('border-red-500');
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua field yang wajib diisi (*)');
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            });

            // Remove error styling on input
            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('border-red-500');
                });
            });
        });
    </script>

@endsection
