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
        Schema::table('patient_profiles', function (Blueprint $table) {
            $table->string('profile_photo_path')->nullable()->after('riwayat_penyakit');
            $table->string('ktp_photo_path')->nullable()->after('profile_photo_path');
            $table->string('kk_photo_path')->nullable()->after('ktp_photo_path');
            $table->string('bpjs_photo_path')->nullable()->after('kk_photo_path');
            $table->string('rme_card_photo_path')->nullable()->after('bpjs_photo_path');
            $table->string('supporting_identity_photo_path')->nullable()->after('rme_card_photo_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'profile_photo_path',
                'ktp_photo_path',
                'kk_photo_path',
                'bpjs_photo_path',
                'rme_card_photo_path',
                'supporting_identity_photo_path',
            ]);
        });
    }
};
