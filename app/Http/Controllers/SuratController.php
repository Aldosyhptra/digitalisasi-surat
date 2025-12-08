<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisSurat;
use App\Models\Surat;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    /**
     * Tampilkan semua jenis surat (Admin)
     */
    public function showAllSurat()
    {
        $jenisSuratList = JenisSurat::all();
        
        return view('layouts.admin.surat', [
            'jenisSuratList' => $jenisSuratList,
            'title' => 'Manajemen Surat'
        ]);
    }

    /**
     * Tampilkan form upload template
     */
    public function showUploadForm()
    {
        $jenisSuratList = JenisSurat::all();
        
        return view('layouts.admin.pengajuan_surat', [
            'jenisSuratList' => $jenisSuratList,
            'title' => 'Upload Template Surat'
        ]);
    }

    /**
     * Upload template baru
     */
    public function upload(Request $request)
    {
        $request->validate([
            'jenis_surat_id' => 'required|exists:jenis_surats,id',
            'template_file' => 'required|mimes:docx|max:5120',
            'fields' => 'required|array|min:1',
            'fields.*.name' => 'required|string',
            'fields.*.label' => 'required|string',
            'fields.*.type' => 'required|in:text,textarea,date,number',
        ]);

        $jenisSurat = JenisSurat::findOrFail($request->jenis_surat_id);

        // Simpan file template
        $path = $request->file('template_file')->store('templates/surat');

        // Format fields
        $fields = [];
        foreach ($request->fields as $field) {
            $fields[] = [
                'name' => $field['name'],
                'label' => $field['label'],
                'type' => $field['type'],
                'required' => isset($field['required']) ? true : false
            ];
        }

        // Update jenis surat
        $jenisSurat->update([
            'template_file' => $path,
            'fields' => $fields,
        ]);

        return redirect()->route('admin.surat')->with('success', 'Template berhasil diupload!');
    }

    /**
     * Update template yang sudah ada
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'template_file' => 'nullable|mimes:docx|max:5120',
            'fields' => 'required|array|min:1',
            'fields.*.name' => 'required|string',
            'fields.*.label' => 'required|string',
            'fields.*.type' => 'required|in:text,textarea,date,number',
        ]);

        $jenisSurat = JenisSurat::findOrFail($id);

        // Jika ada file baru, hapus yang lama dan simpan yang baru
        if ($request->hasFile('template_file')) {
            if ($jenisSurat->template_file && Storage::exists($jenisSurat->template_file)) {
                Storage::delete($jenisSurat->template_file);
            }
            $path = $request->file('template_file')->store('templates/surat');
            $jenisSurat->template_file = $path;
        }

        // Format fields
        $fields = [];
        foreach ($request->fields as $field) {
            $fields[] = [
                'name' => $field['name'],
                'label' => $field['label'],
                'type' => $field['type'],
                'required' => isset($field['required']) ? true : false
            ];
        }

        $jenisSurat->fields = $fields;
        $jenisSurat->save();

        return redirect()->route('admin.surat')->with('success', 'Template berhasil diupdate!');
    }

    /**
     * Hapus template
     */
    public function hapus($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);

        // Hapus file template
        if ($jenisSurat->template_file && Storage::exists($jenisSurat->template_file)) {
            Storage::delete($jenisSurat->template_file);
        }

        // Reset template dan fields
        $jenisSurat->update([
            'template_file' => null,
            'fields' => null,
        ]);

        return redirect()->route('admin.surat')->with('success', 'Template berhasil dihapus!');
    }

    /**
     * Generate surat dari data pengajuan warga
     */
    public function generate($suratId)
    {
        try {
            // Ambil data pengajuan surat dari tabel surats
            $surat = Surat::with('user', 'jenisSurat')->findOrFail($suratId);
            $jenisSurat = $surat->jenisSurat;

            // Cek apakah template tersedia
            if (!$jenisSurat->template_file || !Storage::exists($jenisSurat->template_file)) {
                return back()->with('error', 'Template surat tidak ditemukan.');
            }

            $templatePath = storage_path('app/' . $jenisSurat->template_file);

            // Load template DOCX
            $template = new TemplateProcessor($templatePath);

            // ✅ PERUBAHAN: Ambil data dari kolom data_surat (JSON)
            $dataSurat = $surat->data_surat; // Ini sudah auto-cast ke array

            // Replace placeholder dengan data dari data_surat
            foreach ($dataSurat as $fieldName => $value) {
                // Handle nilai kosong
                $value = $value ?? '-';
                
                // Replace placeholder di template
                // Contoh: ${nama} akan diganti dengan value dari $dataSurat['nama']
                $template->setValue($fieldName, $value);
            }

            // ✅ Data tambahan otomatis (tidak dari form user)
            $template->setValue('tanggal_surat', now()->format('d F Y'));
            $template->setValue('user_nama', $surat->user->nama ?? '-');
            $template->setValue('user_email', $surat->user->email ?? '-');

            // Generate nama file output
            $namaFile = 'surat_' . 
                        str_replace(' ', '_', strtolower($jenisSurat->nama_surat)) . '_' . 
                        str_replace(' ', '_', strtolower($surat->user->nama)) . '_' . 
                        time() . '.docx';
            
            $outputPath = 'surat/generated/' . $namaFile;
            
            // Pastikan folder ada
            Storage::makeDirectory('surat/generated');
            
            // Simpan file hasil generate
            $template->saveAs(storage_path('app/' . $outputPath));

            // Update status surat dan simpan path file
            $surat->update([
                'file_surat' => $outputPath,
                'status' => 'disetujui',
                'tanggal_disetujui' => now(),
            ]);

            // Download file
            return response()->download(storage_path('app/' . $outputPath))
                ->deleteFileAfterSend(false); // Jangan hapus file setelah download

        } catch (\Exception $e) {
            \Log::error('Error generate surat: ' . $e->getMessage());
            return back()->with('error', 'Gagal generate surat: ' . $e->getMessage());
        }
    }

    /**
     * APPROVE SURAT (Auto Generate)
     * Ketika admin approve, otomatis generate surat
     */
    public function approve($suratId)
    {
        $surat = Surat::findOrFail($suratId);
        
        if ($surat->status !== 'pending') {
            return back()->with('error', 'Surat sudah diproses sebelumnya.');
        }

        // Langsung generate surat
        return $this->generate($suratId);
    }

    /**
     * Reject/Tolak surat
     */
    public function reject(Request $request, $suratId)
    {
        $request->validate([
            'catatan' => 'required|string|min:10'
        ], [
            'catatan.required' => 'Alasan penolakan wajib diisi',
            'catatan.min' => 'Alasan penolakan minimal 10 karakter'
        ]);

        $surat = Surat::findOrFail($suratId);
        
        $surat->update([
            'status' => 'ditolak',
            'catatan' => $request->catatan
        ]);

        return back()->with('success', 'Surat berhasil ditolak.');
    }

    /**
     * Download surat yang sudah jadi (User/Admin)
     */
    public function download($suratId)
    {
        $surat = Surat::findOrFail($suratId);

        // Validasi: user hanya bisa download surat miliknya sendiri
        if (auth()->user()->role !== 'admin' && $surat->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke surat ini.');
        }

        if (!$surat->file_surat || !Storage::exists($surat->file_surat)) {
            return back()->with('error', 'File surat tidak tersedia.');
        }

        return response()->download(storage_path('app/' . $surat->file_surat));
    }

    /**
     *LIHAT DETAIL PENGAJUAN (untuk admin review)
     */
    public function show($suratId)
    {
        $surat = Surat::with('user', 'jenisSurat')->findOrFail($suratId);
        
        return view('admin.surat.detail', [
            'surat' => $surat,
            'title' => 'Detail Pengajuan Surat'
        ]);
    }
    public function storeJenisSurat(Request $request)
{
    $request->validate([
        'nama_surat' => 'required|string|max:255',
        'jenis' => 'required|in:sktm,domisili,usaha,lainnya',
        'deskripsi' => 'required|string|max:500',
    ]);

    try {
        $jenisSurat = JenisSurat::create([
            'nama_surat' => $request->nama_surat,
            'jenis' => $request->jenis,
            'deskripsi' => $request->deskripsi,
            'template_file' => null,
            'fields' => null,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jenis surat berhasil ditambahkan',
            'jenis_surat' => $jenisSurat
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menyimpan jenis surat: ' . $e->getMessage()
        ], 500);
    }
}

public function permohonanSuratPengguna()
{
    $rows = Surat::with(['jenisSurat', 'user'])
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($item) {
            return (object) [
                'id'        => $item->id,
                'nama'      => $item->user->nama ?? '-',
                'nik'       => $item->user->nik ?? '-',
                'jenis'     => $item->jenisSurat->nama_surat ?? '-',
                'keperluan' => $item->catatan ?? '-',  
                'status'    => ucfirst($item->status ?? 'Pending'),
                'tanggal'   => $item->created_at,
                'file'      => $item->file_surat ?? null,
            ];
        });

    return view('layouts.admin.permohonan', [
        'title' => 'Data Permohonan',
        'rows'  => $rows
    ]);
}


/**
     * ============================================
     * USER/PENGGUNA METHODS
     * ============================================
     */

    /**
     * Halaman pilih jenis surat untuk warga
     */
    public function pilihSurat()
    {
        $jenisSuratList = JenisSurat::whereNotNull('template_file')
                                     ->whereNotNull('fields')
                                     ->where('is_active', true)
                                     ->orderBy('nama_surat', 'asc')
                                     ->get();

        return view('components.pengguna.ajukansurat.ajukan-surat', [
            'jenisSuratList' => $jenisSuratList,
            'title' => 'Ajukan Surat'
        ]);
    }

    /**
     * Form pengajuan surat berdasarkan jenis
     */
    public function formAjukan($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);

        // Validasi template tersedia
        if (!$jenisSurat->template_file || !$jenisSurat->fields) {
            return redirect()
                ->route('pengajuan.surat')
                ->with('error', 'Template surat belum tersedia. Silakan pilih jenis surat lain.');
        }

        return view('components.pengguna.ajukansurat.form_template', [
            'jenisSurat' => $jenisSurat,
            'title' => 'Ajukan ' . $jenisSurat->nama_surat
        ]);
    }

    /**
     * Proses pengajuan surat dari warga
     */
    public function submitAjukan(Request $request)
{
    try {
        $jenisSurat = JenisSurat::findOrFail($request->jenis_surat_id);

        // Validasi
        $rules = [
            'jenis_surat_id' => 'required|exists:jenis_surats,id',
            'catatan' => 'nullable|string|max:500'
        ];

        foreach ($jenisSurat->fields as $field) {
            if (!empty($field['required'])) {
                $rules["data_surat.{$field['name']}"] = 'required';
            }
        }

        $validated = $request->validate($rules);

        $surat = Surat::create([
            'user_id' => auth()->id(),
            'jenis_surat_id' => $request->jenis_surat_id,
            'data_surat' => $request->data_surat,
            'catatan' => $request->catatan,
            'status' => 'pending',
        ]);

        // Pastikan folder generated ada
        $generatedDir = storage_path('app/private/generated');
        if (!file_exists($generatedDir)) mkdir($generatedDir, 0777, true);

        // Path template
        $templatePath = storage_path("app/private/{$jenisSurat->template_file}");
        if (!file_exists($templatePath)) {
            \Log::error('Template path not found: ' . $templatePath);
            throw new \Exception("Template tidak ditemukan");
        }

        // Load template DOCX
        $template = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

        // Replace variable ${...}
        foreach ($request->data_surat as $key => $val) {
            $template->setValue($key, $val ?? '');
        }

        // Simpan DOCX sementara
        $docxPath = $generatedDir . "/surat-{$surat->id}.docx";
        $template->saveAs($docxPath);

        // Konversi ke PDF
        \PhpOffice\PhpWord\Settings::setPdfRenderer(
            \PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF,
            base_path('vendor/dompdf/dompdf')
        );

        $phpWord = \PhpOffice\PhpWord\IOFactory::load($docxPath);
        $pdfPath = $generatedDir . "/surat-{$surat->id}.pdf";
        $pdfWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
        $pdfWriter->save($pdfPath);

        // Update database
        $surat->update([
            'file_surat' => "private/generated/surat-{$surat->id}.pdf"
        ]);

        return redirect()
            ->route('riwayat-pengajuan.detail', $surat->id)
            ->with('success', 'Pengajuan berhasil! File PDF berhasil dibuat.');

    } catch (\Exception $e) {
        \Log::error('Error submit surat: ' . $e->getMessage());
        return back()
            ->with('error', 'Gagal mengajukan surat: ' . $e->getMessage());
    }
}

public function previewSurat($id)
{
    $surat = Surat::findOrFail($id);
    $path = storage_path("app/{$surat->file_surat}");

    if (!file_exists($path)) {
        abort(404, 'File PDF tidak ditemukan.');
    }

    return response()->file($path, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="surat-' . $surat->id . '.pdf"',
        'Access-Control-Allow-Origin' => '*',
        'Cache-Control' => 'public, max-age=3600',
    ]);
}


    /**
     * Detail pengajuan surat
     */
    public function detailSurat($id)
{
    $query = Surat::with('jenisSurat');

    // Jika penduduk → hanya bisa lihat surat miliknya
    if (auth()->user()->role === 'penduduk') {
        $query->where('user_id', auth()->id());
    }

    $surat = $query->findOrFail($id);

    return view(
        auth()->user()->role === 'penduduk'
            ? 'components.pengguna.riwayatpengajuan.detail_pengajuan'
            : 'components.admin.surat.detail_pengajuan', 
        [
            'surat' => $surat,
            'title' => 'Detail Pengajuan'
        ]
    );
}


    /**
     * Download surat yang sudah disetujui
     */
    public function downloadSurat($id)
    {
        $surat = Surat::where('user_id', auth()->id())
                      ->where('id', $id)
                      ->firstOrFail();

        if ($surat->status !== 'disetujui' || !$surat->file_surat) {
            return back()->with('error', 'Surat belum bisa didownload.');
        }

        if (!Storage::exists($surat->file_surat)) {
            return back()->with('error', 'File surat tidak ditemukan.');
        }

        return response()->download(storage_path('app/' . $surat->file_surat));
    }

    /**
     * Riwayat pengajuan surat user
     */
    public function riwayatSurat()
    {
        $userId = auth()->id();

        // Ambil semua pengajuan milik user, load relasi jenisSurat
        $suratList = Surat::with('jenisSurat')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            // map agar blade lebih sederhana: pastikan tetap instanceof Collection
            ->map(function ($item) {
                return (object) [
                    'id' => $item->id,
                    // ambil nama surat dari relasi; fallback '-'
                    'jenis' => $item->jenisSurat->nama_surat ?? '-',
                    // keperluan diambil dari kolom catatan (boleh kosong)
                    'keperluan' => $item->catatan ?? '-',
                    'tanggal' => $item->created_at,
                    'status' => ucfirst($item->status ?? 'pending'),
                    // sisipan file_surat jika diperlukan pada view
                    'file_surat' => $item->file_surat ?? null,
                ];
            });

        // Gunakan view yang sudah kamu pakai sebelumnya
        return view('components.Pengguna.RiwayatPengajuan.riwayat', [
            'suratList' => $suratList,
            'title' => 'Riwayat Pengajuan Surat'
        ]);
    }

}