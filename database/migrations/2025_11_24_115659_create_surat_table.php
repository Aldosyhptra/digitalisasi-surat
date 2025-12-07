<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('jenis_surat_id')->constrained('jenis_surats')->onDelete('cascade'); // ✅ Tambah nama tabel
            $table->json('data_surat'); // ✅ Data field yang diisi user (dinamis)
            $table->string('file_surat')->nullable(); // File hasil generate
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('catatan')->nullable(); // Catatan admin jika ditolak
            $table->timestamp('tanggal_disetujui')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surats'); // ✅ Perbaiki dari 'surat' jadi 'surats'
    }
};