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
        Schema::table('queues', function (Blueprint $table) {
            $table->string('token')->nullable()->unique()->after('status');
            $table->timestamp('token_scanned_at')->nullable()->after('token');
            $table->string('qr_path')->nullable()->after('token_scanned_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('queues', function (Blueprint $table) {
            $table->dropColumn(['token','token_scanned_at','qr_path']);
        });
    }
};
