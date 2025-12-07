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
}