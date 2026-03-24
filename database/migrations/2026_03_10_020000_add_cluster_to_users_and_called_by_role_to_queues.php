<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'cluster_number')) {
                $table->unsignedTinyInteger('cluster_number')->nullable()->after('role');
            }
        });

        Schema::table('queues', function (Blueprint $table) {
            if (!Schema::hasColumn('queues', 'called_by_role')) {
                $table->string('called_by_role')->nullable()->after('called_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('queues', function (Blueprint $table) {
            if (Schema::hasColumn('queues', 'called_by_role')) {
                $table->dropColumn('called_by_role');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'cluster_number')) {
                $table->dropColumn('cluster_number');
            }
        });
    }
};
