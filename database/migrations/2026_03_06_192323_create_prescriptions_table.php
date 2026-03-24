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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_examination_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_obat');
            $table->string('jumlah')->nullable();
            $table->string('dosis')->nullable();
            $table->string('aturan_pakai')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['menunggu', 'disiapkan', 'diambil'])->default('menunggu');
            $table->timestamp('waktu_diambil')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
