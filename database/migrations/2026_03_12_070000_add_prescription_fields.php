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
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->string('nomor_resep')->nullable()->after('medical_examination_id');
            $table->date('tanggal_resep')->nullable()->after('nomor_resep');
            $table->string('nama_dokter')->nullable()->after('tanggal_resep');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn(['nomor_resep', 'tanggal_resep', 'nama_dokter']);
        });
    }
};
