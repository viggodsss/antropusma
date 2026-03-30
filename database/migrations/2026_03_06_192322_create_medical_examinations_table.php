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
        Schema::create('medical_examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('queue_id')->nullable()->constrained()->onDelete('set null');
            $table->date('tanggal_periksa');
            $table->string('dokter_pemeriksa')->nullable();
            $table->string('poli_tujuan')->nullable();
            $table->text('keluhan_utama')->nullable();
            $table->text('riwayat_penyakit_sekarang')->nullable();
            $table->integer('tekanan_darah_sistolik')->nullable();
            $table->integer('tekanan_darah_diastolik')->nullable();
            $table->integer('nadi')->nullable();
            $table->decimal('suhu', 4, 1)->nullable();
            $table->integer('respirasi')->nullable();
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->text('hasil_pemeriksaan_fisik')->nullable();
            $table->text('diagnosa')->nullable();
            $table->string('kode_icd10')->nullable();
            $table->text('tindakan')->nullable();
            $table->text('anjuran')->nullable();
            $table->enum('status', ['belum_selesai', 'selesai'])->default('belum_selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_examinations');
    }
};
