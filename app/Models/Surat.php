<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surats';

    protected $fillable = [
        'user_id',
        'jenis_surat_id',
        'data_surat',
        'file_surat',
        'status',
        'catatan',
        'tanggal_disetujui',
    ];

    protected $casts = [
        'data_surat' => 'array',
        'tanggal_disetujui' => 'datetime',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke JenisSurat
    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }
}