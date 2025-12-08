@extends('layouts.pengajuan_surat')

@section('content')
    <div class="w-full mx-auto px-6 py-10">

        {{-- Back Button --}}
        <a href="{{ url()->previous() }}"
            class="inline-flex items-center text-gray-600 hover:text-blue-800 mb-8 text-base transition">
            <span class="text-xl mr-2">←</span> Kembali
        </a>

        {{-- Progress Step --}}
        <div class="bg-white shadow-xl rounded-2xl p-8 mb-12 border border-gray-300">
            <div class="relative w-full flex items-center justify-between px-0 sm:px-6">

                @php
                    $step = match ($surat->status) {
                        'pending', 'verifikasi' => 1,
                        'proses' => 2,
                        'selesai', 'disetujui', 'ditolak' => 3,
                        default => 1,
                    };
                    $step3Color = $surat->status === 'ditolak' ? 'bg-red-600 text-white' : 'bg-blue-600 text-white';
                @endphp

                <div class="relative w-full flex items-center justify-between mt-6">

                    {{-- Garis Progress --}}
                    <div
                        class="absolute top-6 left-[9%] w-[35%] h-[4px] {{ $step >= 2 ? 'bg-blue-500' : 'bg-gray-300' }} rounded-full z-0">
                    </div>
                    <div
                        class="absolute top-6 left-[56%] w-[35%] h-[4px] {{ $step == 3 ? ($surat->status === 'ditolak' ? 'bg-red-500' : 'bg-blue-500') : 'bg-gray-300' }} rounded-full z-0">
                    </div>

                    {{-- STEP 1 --}}
                    <div class="flex flex-col items-center z-10">
                        <div
                            class="w-12 h-12 flex items-center justify-center rounded-full {{ $step >= 1 ? 'bg-blue-600 text-white' : 'bg-gray-300' }}">
                        </div>
                        <span class="mt-2 text-sm">Pengajuan</span>
                    </div>

                    {{-- STEP 2 --}}
                    <div class="flex flex-col items-center z-10">
                        <div
                            class="w-12 h-12 flex items-center justify-center rounded-full {{ $step >= 2 ? 'border-4 border-blue-600 bg-white text-blue-600' : 'bg-gray-300' }}">
                        </div>
                        <span class="mt-2 text-sm">Progress</span>
                    </div>

                    {{-- STEP 3 --}}
                    <div class="flex flex-col items-center z-10">
                        <div
                            class="w-12 h-12 flex items-center justify-center rounded-full {{ $step == 3 ? $step3Color : 'bg-gray-300' }}">
                        </div>
                        <span class="mt-2 text-sm">{{ $surat->status === 'ditolak' ? 'Ditolak' : 'Disetujui' }}</span>
                    </div>

                </div>
            </div>
        </div>

        {{-- PDF Preview --}}
        <div class="bg-white shadow-md rounded-xl p-4 sm:p-6 border border-gray-200 w-full overflow-auto">
            @if ($surat->file_surat)
                <div id="pdf-container" class="mx-auto" style="width:100%; max-width:800px;"></div>
            @else
                <p class="text-center text-gray-500 py-10">Surat belum tersedia untuk preview.</p>
            @endif
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.6.172/pdf.min.js"></script>

    <script>
        @if ($surat->file_surat)
            const url = "{{ route('surat.preview', $surat->id) }}";
            const container = document.getElementById('pdf-container');

            pdfjsLib.GlobalWorkerOptions.workerSrc =
                'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.6.172/pdf.worker.min.js';

            async function renderPDF() {
                try {
                    const pdf = await pdfjsLib.getDocument(url).promise;

                    for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                        const page = await pdf.getPage(pageNum);
                        const viewport = page.getViewport({
                            scale: 1.2
                        }); // scale lebih aman

                        const canvas = document.createElement('canvas');
                        canvas.width = viewport.width;
                        canvas.height = viewport.height;
                        canvas.classList.add('mx-auto', 'my-4', 'border', 'shadow');

                        container.appendChild(canvas);

                        await page.render({
                            canvasContext: canvas.getContext('2d'),
                            viewport
                        }).promise;
                    }
                } catch (err) {
                    console.error("PDF loading error:", err);
                    container.innerHTML =
                        "<p class='text-red-500 text-center py-10'>Gagal memuat PDF.</p>";
                }
            }

            renderPDF();
        @endif
    </script>
@endsection
