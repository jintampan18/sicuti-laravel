<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuan_cutis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pegawai_id');
            $table->unsignedBigInteger('jenis_cuti_id');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('durasi');
            $table->text('alasan');
            $table->string('dokumen_pendukung')->nullable();
            $table->enum('status_staff_admin', ['proses', 'diverifikasi', 'direvisi', 'ditolak'])->default('proses');
            $table->text('catatan_staff_admin')->nullable();
            $table->date('tanggal_verifikasi_admin')->nullable();
            $table->enum('status_direktur', ['proses', 'disetujui', 'ditolak'])->default('proses');
            $table->text('catatan_direktur')->nullable();
            $table->date('tanggal_verifikasi_direktur')->nullable();
            $table->timestamps();

            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
            $table->foreign('jenis_cuti_id')->references('id')->on('jenis_cuti')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_cutis');
    }
};
