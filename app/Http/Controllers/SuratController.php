<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisSurat;
use App\Models\Surat;

class SuratController extends Controller
{
    public function uploadTemplate(Request $r, $id)
{
    $r->validate([
        'template_file' => 'required|mimes:docx',
        'fields' => 'required|array'
    ]);

    $jenis = JenisSurat::findOrFail($id);

    $path = $r->file('template_file')->store('templates');

    $jenis->update([
        'template_file' => $path,
        'fields' => $r->fields,
    ]);

    return back()->with('success', 'Template surat berhasil diperbarui.');
}

public function store(Request $r)
{
    $r->validate([
        'jenis_surat_id' => 'required',
        'keperluan' => 'required'
    ]);

    Surat::create([
        'user_id' => auth()->id(),
        'jenis_surat_id' => $r->jenis_surat_id,
        'keperluan' => $r->keperluan,
    ]);

    return redirect()->route('riwayat.pengajuan');
}

public function generateSurat($id)
{
    $surat = Surat::with('user','jenisSurat')->findOrFail($id);
    $jenis = $surat->jenisSurat;

    $templatePath = storage_path('app/' . $jenis->template_file);

    $template = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

    // Replace placeholder sesuai fields JSON
    foreach ($jenis->fields as $field) {
        $template->setValue($field, $surat->user->$field ?? '-');
    }

    $template->setValue('keperluan', $surat->keperluan);

    $output = 'surat/generated_' . time() . '.docx';
    $template->saveAs(storage_path('app/' . $output));

    $surat->update([
        'file_surat' => $output,
        'status' => 'disetujui',
        'tanggal_disetujui' => now(),
    ]);

    return response()->download(storage_path('app/'.$output));
}



}
