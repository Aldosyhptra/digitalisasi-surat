<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $table = 'surat';

    protected $fillable = [
        'user_id',
        'jenis_surat_id',
        'no_surat',
        'keperluan',
        'file_surat',
        'status',
        'catatan_verifikasi',
        'tanggal_diajukan',
        'tanggal_disetujui',
        'tanggal_selesai',
        'wa_notified'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenis()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    public static function generateNoSurat($jenis)
    {
        $bulan = date('m');
        $tahun = date('Y');

        return $jenis->kode . "/" . uniqid() . "/{$bulan}/{$tahun}";
    }
}
