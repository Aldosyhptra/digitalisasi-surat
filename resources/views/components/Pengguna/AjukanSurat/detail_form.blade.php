@extends('layouts.pengajuan_surat')

@section('content')

    <div class="max-w-5xl mx-auto px-4 py-6 space-y-6">

        {{-- Header --}}
        <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm">
            <div class="flex items-start gap-4">
                <a href="{{ route('riwayat.pengajuan') }}"
                    class="flex-shrink-0 w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 
                      flex items-center justify-center transition">
                    <i class="fas fa-arrow-left text-gray-600"></i>
                </a>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Detail Pengajuan Surat</h1>
                    <p class="text-gray-600 text-sm">Informasi lengkap pengajuan surat Anda</p>
                </div>
            </div>
        </div>

        {{-- Status Card --}}
        <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm">
            @php
                $statusConfig = [
                    'pending' => [
                        'icon' => 'fa-clock',
                        'color' => 'yellow',
                        'bgColor' => 'bg-yellow-50',
                        'borderColor' => 'border-yellow-200',
                        'textColor' => 'text-yellow-700',
                        'label' => 'Menunggu Persetujuan',
                        'desc' => 'Pengajuan Anda sedang menunggu untuk diproses oleh admin',
                    ],
                    'diproses' => [
                        'icon' => 'fa-spinner',
                        'color' => 'blue',
                        'bgColor' => 'bg-blue-50',
                        'borderColor' => 'border-blue-200',
                        'textColor' => 'text-blue-700',
                        'label' => 'Sedang Diproses',
                        'desc' => 'Surat Anda sedang dalam proses pembuatan',
                    ],
                    'disetujui' => [
                        'icon' => 'fa-check-circle',
                        'color' => 'green',
                        'bgColor' => 'bg-green-50',
                        'borderColor' => 'border-green-200',
                        'textColor' => 'text-green-700',
                        'label' => 'Disetujui',
                        'desc' => 'Surat Anda telah disetujui dan siap didownload',
                    ],
                    'ditolak' => [
                        'icon' => 'fa-times-circle',
                        'color' => 'red',
                        'bgColor' => 'bg-red-50',
                        'borderColor' => 'border-red-200',
                        'textColor' => 'text-red-700',
                        'label' => 'Ditolak',
                        'desc' => 'Pengajuan surat Anda ditolak',
                    ],
                ];
                $config = $statusConfig[$surat->status] ?? $statusConfig['pending'];
            @endphp

            <div class="flex items-start gap-4">
                <div
                    class="w-16 h-16 rounded-xl bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-700 
                        flex items-center justify-center flex-shrink-0">
                    <i class="fas {{ $config['icon'] }} text-3xl"></i>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-gray-800 mb-1">{{ $config['label'] }}</h2>
                    <p class="text-gray-600 text-sm mb-3">{{ $config['desc'] }}</p>

                    <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                        <span>
                            <i class="fas fa-calendar mr-1"></i>
                            Diajukan: {{ $surat->created_at->format('d M Y, H:i') }}
                        </span>
                        @if ($surat->updated_at != $surat->created_at)
                            <span>
                                <i class="fas fa-sync mr-1"></i>
                                Diperbarui: {{ $surat->updated_at->format('d M Y, H:i') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Alasan Penolakan --}}
            @if ($surat->status === 'ditolak' && $surat->alasan_penolakan)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="{{ $config['bgColor'] }} border {{ $config['borderColor'] }} rounded-xl p-4">
                        <p class="font-semibold {{ $config['textColor'] }} mb-2">
                            <i class="fas fa-exclamation-circle mr-2"></i>Alasan Penolakan:
                        </p>
                        <p class="text-gray-700 text-sm">{{ $surat->alasan_penolakan }}</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Info Surat --}}
        <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">
                <i class="fas fa-file-alt mr-2 text-blue-600"></i>Informasi Surat
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Jenis Surat</p>
                    <p class="font-semibold text-gray-800">{{ $surat->jenisSurat->nama_surat }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Nomor Pengajuan</p>
                    <p class="font-semibold text-gray-800 font-mono">
                        #{{ str_pad($surat->id, 6, '0', STR_PAD_LEFT) }}
                    </p>
                </div>
            </div>

            @if ($surat->jenisSurat->deskripsi)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Deskripsi</p>
                    <p class="text-gray-700">{{ $surat->jenisSurat->deskripsi }}</p>
                </div>
            @endif
        </div>

        {{-- Data Pengajuan --}}
        <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">
                <i class="fas fa-database mr-2 text-blue-600"></i>Data Pengajuan
            </h3>

            @if ($surat->data_surat && count($surat->data_surat) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($surat->data_surat as $key => $value)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-600 mb-1 font-medium">
                                {{ ucfirst(str_replace('_', ' ', $key)) }}
                            </p>
                            <p class="text-gray-800">
                                @if (is_array($value))
                                    {{ implode(', ', $value) }}
                                @elseif(is_bool($value))
                                    {{ $value ? 'Ya' : 'Tidak' }}
                                @else
                                    {{ $value ?: '-' }}
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Tidak ada data pengajuan</p>
            @endif
        </div>

        {{-- Catatan --}}
        @if ($surat->catatan)
            <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">
                    <i class="fas fa-sticky-note mr-2 text-blue-600"></i>Catatan Tambahan
                </h3>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-gray-700">{{ $surat->catatan }}</p>
                </div>
            </div>
        @endif

        {{-- Timeline --}}
        <div class="bg-white border border-gray-300 rounded-2xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">
                <i class="fas fa-history mr-2 text-blue-600"></i>Timeline Proses
            </h3>

            <div class="space-y-4">
                {{-- Created --}}
                <div class="flex items-start gap-4">
                    <div
                        class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 text-blue-700 
                            flex items-center justify-center">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">Pengajuan Dibuat</p>
                        <p class="text-sm text-gray-600">{{ $surat->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                {{-- Processed --}}
                @if ($surat->status !== 'pending')
                    <div class="flex items-start gap-4">
                        <div
                            class="flex-shrink-0 w-10 h-10 rounded-full bg-yellow-100 text-yellow-700 
                                flex items-center justify-center">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">Sedang Diproses</p>
                            <p class="text-sm text-gray-600">{{ $surat->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                @endif

                {{-- Completed --}}
                @if ($surat->status === 'disetujui' || $surat->status === 'ditolak')
                    <div class="flex items-start gap-4">
                        <div
                            class="flex-shrink-0 w-10 h-10 rounded-full 
                                {{ $surat->status === 'disetujui' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}
                                flex items-center justify-center">
                            <i class="fas {{ $surat->status === 'disetujui' ? 'fa-check' : 'fa-times' }}"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">
                                {{ $surat->status === 'disetujui' ? 'Disetujui' : 'Ditolak' }}
                            </p>
                            <p class="text-sm text-gray-600">{{ $surat->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('user.surat.riwayat') }}"
                class="flex-1 py-3 px-6 bg-gray-100 text-gray-700 rounded-xl 
                  hover:bg-gray-200 transition text-center font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Riwayat
            </a>

            @if ($surat->status === 'disetujui' && $surat->file_surat)
                <a href="{{ route('user.surat.download', $surat->id) }}"
                    class="flex-1 py-3 px-6 bg-green-600 text-white rounded-xl 
                      hover:bg-green-700 transition text-center font-medium">
                    <i class="fas fa-download mr-2"></i>Download Surat
                </a>
            @endif

            @if ($surat->status === 'ditolak')
                <a href="{{ route('user.surat.form', $surat->jenis_surat_id) }}"
                    class="flex-1 py-3 px-6 bg-blue-600 text-white rounded-xl 
                      hover:bg-blue-700 transition text-center font-medium">
                    <i class="fas fa-redo mr-2"></i>Ajukan Ulang
                </a>
            @endif
        </div>

    </div>

@endsection
