<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 20)->nullable()->after('email');
            }

            if (!Schema::hasColumn('users', 'otp_code_hash')) {
                $table->string('otp_code_hash')->nullable()->after('verified_at');
            }

            if (!Schema::hasColumn('users', 'otp_expires_at')) {
                $table->timestamp('otp_expires_at')->nullable()->after('otp_code_hash');
            }

            if (!Schema::hasColumn('users', 'otp_attempts')) {
                $table->unsignedSmallInteger('otp_attempts')->default(0)->after('otp_expires_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $dropColumns = [];

            if (Schema::hasColumn('users', 'phone')) {
                $dropColumns[] = 'phone';
            }
            if (Schema::hasColumn('users', 'otp_code_hash')) {
                $dropColumns[] = 'otp_code_hash';
            }
            if (Schema::hasColumn('users', 'otp_expires_at')) {
                $dropColumns[] = 'otp_expires_at';
            }
            if (Schema::hasColumn('users', 'otp_attempts')) {
                $dropColumns[] = 'otp_attempts';
            }

            if ($dropColumns !== []) {
                $table->dropColumn($dropColumns);
            }
        });
    }
};
