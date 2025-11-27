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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('username')->unique();
        $table->string('password');
        $table->string('nik', 20)->unique();
        $table->date('tanggal_lahir')->nullable();
        $table->string('no_wa', 20)->nullable();
        $table->enum('role', ['penduduk','pegawai','admin'])->default('penduduk');
        $table->text('bio')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
