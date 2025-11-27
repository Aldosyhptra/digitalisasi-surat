<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('surat', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('jenis_surat_id')->constrained('jenis_surat')->onDelete('cascade');
        $table->string('no_surat')->nullable();
        $table->text('keperluan')->nullable();
        $table->string('file_surat')->nullable();
        $table->enum('status', ['pending','revisi','disetujui','selesai'])->default('pending');
        $table->text('catatan_verifikasi')->nullable();
        $table->timestamp('tanggal_diajukan')->useCurrent();
        $table->timestamp('tanggal_disetujui')->nullable();
        $table->timestamp('tanggal_selesai')->nullable();
        $table->boolean('wa_notified')->default(false);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
